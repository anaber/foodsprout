<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class UserLib {
	
	var $userId;
	var $email;
	var $zipcode;
	var $firstName;
	var $lastName;
	var $isActive;
	var $isAuthenticated;
	var $access;
	var $joinDate;
	var $username;
		
	function UserLib() {
		$user->userId = "";
		$user->email = "";
		$user->zipcode = "";
		$user->firstName = "";
		$user->lastName = "";
		$this->isActive = 0;
		$this->isAuthenticated = 0;		
		$user->access = "";
		$user->joinDate = "";
		$user->username = "";
	}
}
?>
