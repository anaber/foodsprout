<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class UserLib {
	
	var $userId;
	var $email;
	var $zipcode;
	var $firstName;
	var $lastName;
	var $screenName;
	var $isActive;
	var $isAuthenticated;
	var $userGroup;
	var $joinDate;
		
	function UserLib() {
		$user->userId = "";
		$user->email = "";
		$user->zipcode = "";
		$user->firstName = "";
		$user->lastName = "";
		$user->screenName = "";
		$this->isActive = 0;
		$this->isAuthenticated = 0;		
		$user->userGroup = "";
		$user->joinDate = "";
	}
}
?>
