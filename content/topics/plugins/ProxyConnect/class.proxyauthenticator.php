<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

/**
 * Validates sessions by handshaking with another site by means of direct socket connection
 * 
 * @author Tim Gunter <tim@vanillaforums.com>
 * @package Garden
 */
class Gdn_ProxyAuthenticator extends Gdn_Authenticator implements Gdn_IHandshake {

   protected $_CookieName = NULL;
   protected $Provider = NULL;
   protected $Token = NULL;
   protected $Nonce = NULL;
   
   public function __construct() {

      // This authenticator gets its data directly from the request object, always
      $this->_DataSourceType = Gdn_Authenticator::DATA_NONE;
      
      // Which cookie signals the presence of an authentication package?
      $this->_CookieName = Gdn::Config('Garden.Authenticators.proxy.CookieName', 'VanillaProxy');

      // Initialize built-in authenticator functionality
      parent::__construct();
//$this->Authenticate();
   }
   
   public function Authenticate() {      

      try {
         $Provider = $this->GetProvider();
         if (!$Provider) throw new Exception('Provider not defined');

         $ForeignIdentityUrl = GetValue('AuthenticateUrl', $Provider, FALSE);

         if ($ForeignIdentityUrl === FALSE) throw new Exception('AuthenticateUrl not defined');
         $Response = $this->_GetForeignCredentials($ForeignIdentityUrl);

         if (!$Response) throw new Exception('No response from Authentication URL');

         // @TODO: Response sends provider key, used as parameter to GetProvider()

         // Got a response from the remote identity provider, and loaded matching provider
         $AuthUniqueField = C('Garden.Authenticators.proxy.AuthField','UniqueID');
         $UserUnique = ArrayValue($AuthUniqueField, $Response, NULL);

         if (is_null($UserUnique))
            throw new Exception("Selected AuthUniqueField ({$AuthUniqueField}) not found in Response.");
         
         $UserEmail = ArrayValue('Email', $Response);
         $UserName = ArrayValue('Name', $Response);
         $UserName = trim(preg_replace('/[^a-z0-9- ]+/i','',$UserName));
         $TransientKey = ArrayValue('TransientKey', $Response, NULL);
         
         // Validate remote credentials against local auth tables
         $AuthResponse = $this->ProcessAuthorizedRequest($Provider['AuthenticationKey'], $UserUnique, $UserName, $TransientKey, array(
            'Email'  => $UserEmail
         ));

         Gdn::Authenticator()->Trigger($AuthResponse);
         if ($AuthResponse == Gdn_Authenticator::AUTH_SUCCESS) {
            // Everything's cool, we don't have to do anything.
            
         } elseif ($AuthResponse == Gdn_Authenticator::AUTH_PARTIAL) {
            Redirect(Url('/entry/handshake/proxy',TRUE),302);
         } else {
            Gdn::Request()->WithRoute('DefaultController');
            throw new Exception('authentication failed');
         }
         
      }
      catch (Exception $e) {
         
         // Fallback to defer checking until the next session
         if (substr(Gdn::Request()->Path(),0,6) != 'entry/')
            $this->SetIdentity(-1, FALSE);
      }
   }
   
   public function Finalize($UserKey, $UserID, $ProviderKey, $TokenKey, $CookiePayload) {
   
      // Associate the local UserID with the foreign UserKey
      Gdn::Authenticator()->AssociateUser($ProviderKey, $UserKey,  $UserID);
      
      // Log the user in
      $this->ProcessAuthorizedRequest($ProviderKey, $UserKey);
   }
   
   /**
    * 
    * 
    * 
    * 
    * 
    */
   public function ProcessAuthorizedRequest($ProviderKey, $UserKey, $UserName = NULL, $ForeignNonce = NULL, $OptionalPayload = NULL) {
      
      // Try to load the association for this Provider + UserKey
      $Association = Gdn::Authenticator()->GetAssociation($UserKey, $ProviderKey, Gdn_Authenticator::KEY_TYPE_PROVIDER);
      
      // We havent created a UserAuthentication entry yet. Create one. This will be an un-associated entry.
      if (!$Association) {
         $Association = Gdn::Authenticator()->AssociateUser($ProviderKey, $UserKey, 0);
         
         // Couldn't even create a half-association.
         if (!$Association) 
            return Gdn_Authenticator::AUTH_DENIED;
      }

      if ($Association['UserID'] > 0) {
         // Retrieved an association which has been fully linked to a local user
      
         // We'll be tracked by Vanilla cookies now, so delete the Proxy cookie if it exists...
         $this->DeleteCookie();
         
         // Log the user in
         $this->SetIdentity($Association['UserID'], FALSE);
         
         // Check for a request token that needs to be converted to an access token
         $Token = $this->LookupToken($ProviderKey, $UserKey, 'request');
         
         if ($Token) {
            // Check for a stored Nonce
            $ExistingNonce = $this->LookupNonce($Token['Token']);
            
            // Found one. Copy it as if it was passed in to this method, and then delete it.
            if ($ExistingNonce !== FALSE) {
               $ForeignNonce = $ExistingNonce;
               $this->ClearNonces($Token['Token']);
            }
               
            unset($Token);
         }
         
         $TokenType = 'access';
         $AuthReturn = Gdn_Authenticator::AUTH_SUCCESS;
      } else {
         // This association is not yet associated with a local forum account. 
         
         // Set the memory cookie to trigger the handshake page
         $CookiePayload = array(
            'UserKey'      => $UserKey,
            'ProviderKey'  => $ProviderKey,
            'UserName'     => $UserName,
            'UserOptional' => Gdn_Format::Serialize($OptionalPayload)
         );
         $SerializedCookiePayload = Gdn_Format::Serialize($CookiePayload);
         $this->Remember($ProviderKey, $SerializedCookiePayload);
         
         $TokenType = 'request';
         $AuthReturn = Gdn_Authenticator::AUTH_PARTIAL;

      }
      
      $Token = $this->LookupToken($ProviderKey, $UserKey, $TokenType);
      if (!$Token)
         $Token = $this->CreateToken($TokenType, $ProviderKey, $UserKey, TRUE);
      
      if ($Token && !is_null($ForeignNonce)) {
         $TokenKey = $Token['Token'];
         try {
            $this->SetNonce($TokenKey, $ForeignNonce);
         } catch (Exception $e) {}
      }
      
      return $AuthReturn;
   }
   
   public function Remember($Key, $SerializedCookiePayload) {
   
      Gdn_CookieIdentity::SetCookie($this->_CookieName, $Key, array(1, 0, $SerializedCookiePayload), 0);
   }
   
   public function GetHandshake() {

      $HaveHandshake = Gdn_CookieIdentity::CheckCookie($this->_CookieName);
      
      if ($HaveHandshake) {
         // Found a handshake cookie, sweet. Get the payload.
         $Payload = Gdn_CookieIdentity::GetCookiePayload($this->_CookieName);
         
         // Shift the 'userid' and 'expiration' off the front. These were made-up anyway :D
         array_shift($Payload);
         array_shift($Payload);
         
         // Rebuild the real payload
         $ReconstitutedCookiePayload = Gdn_Format::Unserialize(TrueStripSlashes(array_shift($Payload)));
         
         return $ReconstitutedCookiePayload;
      }
      
      return FALSE;
   }
   
   public function DeleteCookie() {
      Gdn_Cookieidentity::DeleteCookie($this->_CookieName);
   }
   
   public function GetUserKeyFromHandshake($Handshake) {
   
      return ArrayValue('UserKey', $Handshake, FALSE);
   }
   
   public function GetUserNameFromHandshake($Handshake) {
      return ArrayValue('UserName', $Handshake, FALSE);
   }
   
   public function GetProviderKeyFromHandshake($Handshake) {
      return ArrayValue('ProviderKey', $Handshake, FALSE);
   }
   
   public function GetTokenKeyFromHandshake($Handshake) {
      return '';  // this authenticator doesnt use tokens
   }
   
   public function GetUserEmailFromHandshake($Handshake) {
      static $UserOptional = NULL;
      
      if (is_null($UserOptional)) {
         $UserOptional = Gdn_Format::Unserialize(ArrayValue('UserOptional', $Handshake, array()));
      }
      return ArrayValue('Email', $UserOptional, '');
   }
   
   public function DeAuthenticate() {
      $this->SetIdentity(-1, FALSE);
      return Gdn_Authenticator::AUTH_SUCCESS;
   }
   
   // What to do if entry/auth/* is called while the user is logged out. Should normally be REACT_RENDER
   public function LoginResponse() {
   
      return Gdn::Authenticator()->RemoteSignInUrl();
   }
   
   // What to do after part 1 of a 2 part authentication process. This is used in conjunction with OAauth/OpenID type authentication schemes
   public function PartialResponse() {
      return Gdn_Authenticator::REACT_REDIRECT;
   }
   
   // What to do after authentication has succeeded. 
   public function SuccessResponse() {
      return Gdn_Authenticator::REACT_REDIRECT;
   }
   
   // What to do if the entry/auth/* page is triggered for a user that is already logged in
   public function RepeatResponse() {
      return Gdn_Authenticator::REACT_REDIRECT;
   }
   
   // What to do if the entry/leave/* page is triggered for a user that is logged in and successfully logs out
   public function LogoutResponse() {
      return Gdn::Authenticator()->RemoteSignOutUrl();
   }
   
   // What to do if the entry/auth/* page is triggered but login is denied or fails
   public function FailedResponse() {
      return Gdn_Authenticator::REACT_RENDER;
   }
   
   public function GetHandshakeMode() {
      $ModeStr = Gdn::Request()->GetValue('mode', Gdn_Authenticator::HANDSHAKE_DIRECT);
      return $ModeStr;
   }
   
   public function GetURL($URLType) {
      $Provider = $this->GetProvider();
      $Nonce = $this->GetNonce();
      
      // Dirty hack to allow handling Remote* url requests and delegate basic requests to the config
      if (strlen($URLType) == strlen(str_replace('Remote','',$URLType))) return FALSE;
      
      $URLType = str_replace('Remote','',$URLType);
      // If we get here, we're handling a RemoteURL question
      if ($Provider && GetValue($URLType, $Provider, FALSE)) {
         return array(
            'URL'          => $Provider[$URLType],
            'Parameters'   => array(
               'Nonce'  => $Nonce['Nonce']
            )
         );
      }
      
      return FALSE;
   }
   
   protected function _GetForeignCredentials($ForeignIdentityUrl) {

      // Get the contents of the Authentication Url (timeout 5 seconds)
/*      $Response = ProxyRequest($ForeignIdentityUrl,5);
      
	  if ($Response) {
         $ReadMode = strtolower(C("Garden.Authenticators.proxy.RemoteFormat", "ini"));

         switch ($ReadMode) {
            case 'ini':
               $Result = @parse_ini_string($Response);
               break;
               
            case 'json':
               $Result = @json_decode($Response);
               break;
               
            default:
               throw new Exception("Unexpected value '$ReadMode' for 'Garden.Authenticators.proxy.RemoteFormat'");
         }
*/

/*		$Response = ProxyRequest($ForeignIdentityUrl);
		$Response =  urldecode($Response);
		
		if( strpos($Response, 'UniqueID') !== FALSE ) {
			$Response = explode('UniqueID',$Response);
			$Response[1] = "UniqueID".$Response[1];
			$Result = @parse_ini_string($Response[1]);
		}

		$Result = @parse_ini_string(file_get_contents($ForeignIdentityUrl));
*/

		$civ = $_COOKIE['ci_v'];
		list($uid, $name, $email) = explode('|',$civ);
		$uid = base64_decode($uid);
		$name = base64_decode($name);
		$email = base64_decode($email);

         if ( !empty($uid) ) {
            $ReturnArray = array(
               'Email'        => $email,
               'Name'         => $name,
               'UniqueID'     => $uid
//               'TransientKey' => ArrayValue('TransientKey', $Result, NULL)
            );

            return $ReturnArray;
         }

//      }
      return FALSE;
   }
   
   public function CurrentStep() {
      $Id = Gdn::Authenticator()->GetRealIdentity();
      
      if (!$Id) return Gdn_Authenticator::MODE_GATHER;
      if ($Id > 0) return Gdn_Authenticator::MODE_REPEAT;
      if ($Id < 0) return Gdn_Authenticator::MODE_NOAUTH;
   }
   
   public function AuthenticatorConfiguration(&$Sender) {
      // Let the plugin handle the config
      $Sender->AuthenticatorConfigure = NULL;
      $Sender->FireEvent('AuthenticatorConfigurationProxy');
      return $Sender->AuthenticatorConfigure;
   }
   
   public function WakeUp() {
      
      // Allow the entry/handshake method to function
      Gdn::Authenticator()->AllowHandshake();
      
      // Shortcircuit the wakeup if we're already awake
      // 
      // If we're already back on Vanilla and working with the handshake form, don't
      // try to re-wakeup.
      $HaveHandshake = Gdn_CookieIdentity::CheckCookie($this->_CookieName);
      if ($HaveHandshake)
         return;
      
      $CurrentStep = $this->CurrentStep();

      // Shortcircuit to prevent pointless work when the access token has already been handled and we already have a session 
      if ($CurrentStep == Gdn_Authenticator::MODE_REPEAT)
         return;
         
      // Don't try to wakeup when we've already tried once this session
//      if ($CurrentStep == Gdn_Authenticator::MODE_NOAUTH)
//         return;
      
      // Passed all shortcircuits. Try to log in via proxy.
      $this->Authenticate();
   }
   
}