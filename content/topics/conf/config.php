<?php if (!defined('APPLICATION')) exit();

// Cache
$Configuration['Cache']['Enabled'] = TRUE;
$Configuration['Cache']['Method'] = 'dirtycache';
$Configuration['Cache']['Filecache']['Store'] = '/mnt/stor2-wc1-dfw1/404946/492717/www.foodsprout.com/web/content/topics/cache';

// Conversations
$Configuration['Conversations']['Version'] = '2.0.17.8';

// Database
$Configuration['Database']['Name'] = '492717_version2';
$Configuration['Database']['Host'] = 'mysql50-91.wc1.dfw1.stabletransit.com';
$Configuration['Database']['User'] = '492717_v2user';
$Configuration['Database']['Password'] = 'R3alF00dPlease';
$Configuration['Database']['Engine'] = 'MySQL';
$Configuration['Database']['ConnectionOptions']['12'] = FALSE;
$Configuration['Database']['ConnectionOptions']['1000'] = TRUE;
$Configuration['Database']['ConnectionOptions']['1002'] = "set names 'utf8'";
$Configuration['Database']['CharacterEncoding'] = 'utf8';
$Configuration['Database']['DatabasePrefix'] = 'GDN_';
$Configuration['Database']['ExtendedProperties']['Collate'] = 'utf8_unicode_ci';

// EnabledApplications
$Configuration['EnabledApplications']['Dashboard'] = 'dashboard';
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['ProxyConnectManual'] = 'ProxyConnectManualPlugin';
$Configuration['EnabledPlugins']['ProxyConnectWordpress'] = 'ProxyConnectWordpressPlugin';
$Configuration['EnabledPlugins']['ProxyConnect'] = 'ProxyConnect';

// Garden
$Configuration['Garden']['Title'] = 'Food Sprout';
$Configuration['Garden']['Cookie']['Salt'] = '5V1OGT4DE1';
$Configuration['Garden']['Cookie']['Domain'] = '.foodsprout.com';
$Configuration['Garden']['Cookie']['Name'] = 'Vanilla';
$Configuration['Garden']['Cookie']['Path'] = '/';
$Configuration['Garden']['Cookie']['HashMethod'] = 'md5';
$Configuration['Garden']['ContentType'] = 'text/html';
$Configuration['Garden']['Charset'] = 'utf-8';
$Configuration['Garden']['FolderBlacklist'] = array('.', '..', '_svn', '.git');
$Configuration['Garden']['Locale'] = 'en-CA';
$Configuration['Garden']['LocaleCodeset'] = 'UTF8';
$Configuration['Garden']['Domain'] = '';
$Configuration['Garden']['WebRoot'] = FALSE;
$Configuration['Garden']['StripWebRoot'] = FALSE;
$Configuration['Garden']['Debug'] = FALSE;
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['Session']['Length'] = '15 minutes';
$Configuration['Garden']['Authenticator']['RegisterUrl'] = '/entry/register?Target=%2$s';
$Configuration['Garden']['Authenticator']['SignInUrl'] = '/entry/signin?Target=%2$s';
$Configuration['Garden']['Authenticator']['SignOutUrl'] = '/entry/signout/{Session_TransientKey}?Target=%2$s';
$Configuration['Garden']['Authenticator']['EnabledSchemes'] = 'a:2:{i:0;s:8:"password";i:1;s:5:"proxy";}';
$Configuration['Garden']['Authenticator']['SyncScreen'] = 'smart';
$Configuration['Garden']['Authenticator']['DefaultScheme'] = 'proxy';
$Configuration['Garden']['Authenticators']['password']['Name'] = 'Password';
$Configuration['Garden']['Authenticators']['proxy']['Name'] = 'ProxyConnect';
$Configuration['Garden']['Authenticators']['proxy']['CookieName'] = 'VanillaProxy';
$Configuration['Garden']['Errors']['LogEnabled'] = FALSE;
$Configuration['Garden']['Errors']['LogFile'] = '';
$Configuration['Garden']['Errors']['MasterView'] = 'error.master.php';
$Configuration['Garden']['UserAccount']['AllowEdit'] = TRUE;
$Configuration['Garden']['Registration']['Method'] = 'Captcha';
$Configuration['Garden']['Registration']['DefaultRoles'] = array('8');
$Configuration['Garden']['Registration']['ApplicantRoleID'] = 4;
$Configuration['Garden']['Registration']['InviteExpiration'] = '-1 week';
$Configuration['Garden']['Registration']['InviteRoles'] = FALSE;
$Configuration['Garden']['TermsOfService'] = '/dashboard/home/termsofservice';
$Configuration['Garden']['Email']['UseSmtp'] = FALSE;
$Configuration['Garden']['Email']['SmtpHost'] = '';
$Configuration['Garden']['Email']['SmtpUser'] = '';
$Configuration['Garden']['Email']['SmtpPassword'] = '';
$Configuration['Garden']['Email']['SmtpPort'] = '25';
$Configuration['Garden']['Email']['SmtpSecurity'] = '';
$Configuration['Garden']['Email']['MimeType'] = 'text/plain';
$Configuration['Garden']['Email']['SupportName'] = 'Support';
$Configuration['Garden']['Email']['SupportAddress'] = '';
$Configuration['Garden']['UpdateCheckUrl'] = 'http://vanillaforums.org/addons/update';
$Configuration['Garden']['AddonUrl'] = 'http://vanillaforums.org/addons';
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['Forms']['HoneypotName'] = 'hpt';
$Configuration['Garden']['Upload']['MaxFileSize'] = '50M';
$Configuration['Garden']['Upload']['AllowedFileExtensions'] = array('txt', 'jpg', 'gif', 'png', 'bmp', 'zip', 'gz', 'tar.gz', 'tgz', 'psd', 'ai', 'fla', 'swf', 'pdf', 'doc', 'xls', 'ppt', 'docx', 'xlsx', 'log', 'pdf');
$Configuration['Garden']['Picture']['MaxHeight'] = 1000;
$Configuration['Garden']['Picture']['MaxWidth'] = 600;
$Configuration['Garden']['Profile']['MaxHeight'] = 1000;
$Configuration['Garden']['Profile']['MaxWidth'] = 250;
$Configuration['Garden']['Profile']['Public'] = TRUE;
$Configuration['Garden']['Profile']['ShowAbout'] = TRUE;
$Configuration['Garden']['Profile']['EditUsernames'] = FALSE;
$Configuration['Garden']['Preview']['MaxHeight'] = 100;
$Configuration['Garden']['Preview']['MaxWidth'] = 75;
$Configuration['Garden']['Thumbnail']['Size'] = 50;
$Configuration['Garden']['Menu']['Sort'] = array('Dashboard', 'Discussions', 'Questions', 'Activity', 'Applicants', 'Conversations', 'User');
$Configuration['Garden']['InputFormatter'] = 'Html';
$Configuration['Garden']['Html']['SafeStyles'] = TRUE;
$Configuration['Garden']['Search']['Mode'] = 'matchboolean';
$Configuration['Garden']['Theme'] = 'foodsprout';
$Configuration['Garden']['MobileTheme'] = 'mobile';
$Configuration['Garden']['Roles']['Manage'] = TRUE;
$Configuration['Garden']['VanillaUrl'] = 'http://vanillaforums.org';
$Configuration['Garden']['AllowSSL'] = TRUE;
$Configuration['Garden']['PrivateCommunity'] = FALSE;
$Configuration['Garden']['EditContentTimeout'] = -1;
$Configuration['Garden']['Modules']['ShowSignedInModule'] = FALSE;
$Configuration['Garden']['Modules']['ShowRecentUserModule'] = FALSE;
$Configuration['Garden']['Format']['Mentions'] = TRUE;
$Configuration['Garden']['Format']['Hashtags'] = TRUE;
$Configuration['Garden']['Format']['YouTube'] = TRUE;
$Configuration['Garden']['Format']['Vimeo'] = TRUE;
$Configuration['Garden']['Format']['EmbedSize'] = 'normal';
$Configuration['Garden']['Version'] = '2.0.17.8';
$Configuration['Garden']['SignIn']['Popup'] = FALSE;

// Modules
$Configuration['Modules']['Garden']['Panel'] = array('UserPhotoModule', 'UserInfoModule', 'GuestModule', 'Ads');
$Configuration['Modules']['Garden']['Content'] = array('MessageModule', 'Notices', 'Content', 'Ads');
$Configuration['Modules']['Vanilla']['Panel'] = array('NewDiscussionModule', 'SignedInModule', 'GuestModule', 'Ads');
$Configuration['Modules']['Vanilla']['Content'] = array('MessageModule', 'Notices', 'NewConversationModule', 'NewDiscussionModule', 'Content', 'Ads');
$Configuration['Modules']['Conversations']['Panel'] = array('NewConversationModule', 'SignedInModule', 'GuestModule', 'Ads');
$Configuration['Modules']['Conversations']['Content'] = array('MessageModule', 'Notices', 'NewConversationModule', 'NewDiscussionModule', 'Content', 'Ads');

// Plugin
$Configuration['Plugin']['ProxyConnect']['IntegrationManager'] = 'proxyconnectmanual';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['ProxyConnect']['Enabled'] = TRUE;

// Preferences
$Configuration['Preferences']['Email']['ConversationMessage'] = '1';
$Configuration['Preferences']['Email']['AddedToConversation'] = '1';
$Configuration['Preferences']['Email']['BookmarkComment'] = '1';
$Configuration['Preferences']['Email']['WallComment'] = '0';
$Configuration['Preferences']['Email']['ActivityComment'] = '0';
$Configuration['Preferences']['Email']['DiscussionComment'] = '0';
$Configuration['Preferences']['Email']['DiscussionMention'] = '0';
$Configuration['Preferences']['Email']['CommentMention'] = '0';

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';
$Configuration['Routes']['Default404'] = array('dashboard/home/filenotfound', 'NotFound');
$Configuration['Routes']['DefaultPermission'] = array('dashboard/home/permission', 'NotAuthorized');
$Configuration['Routes']['UpdateMode'] = 'dashboard/home/updatemode';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.0.17.8';

// Last edited by admin (127.0.0.1)2011-03-17 15:54:06