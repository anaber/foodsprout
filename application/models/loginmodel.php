<?php

class LoginModel extends Model{
	
	function validateAdmin() {
		$query = 'SELECT user.*, access.*, user_access.* '.
				' FROM user, access, user_access' .
				' WHERE user.email = \'' . trim($this->input->post('email')) . '\'' .
				' AND user.password = \'' . md5( trim($this->input->post('password')) ) . '\'' .
				' AND user.user_id = user_access.user_id' .
				' AND user_access.access_id = access.access_id' .
				' AND access.access = \'admin\' ';
		
		log_message('debug', $query);
		
		$result = $this->db->query($query);
		
		$return = false;
		if ($result->num_rows() > 0) {
			
			$row = $result->row();
			
			if ($row->isActive == 1) {
				
				$this->load->library('UserLib');
				
				$this->user->userId = $row->user_id;
				$this->user->email = $row->email;
				$this->user->zipcode = $row->zipcode;
				$this->user->firstName = $row->first_name;
				//Currently we do not require lastname
				//$this->user->lastName = $row->last_name;
				$this->user->isActive = $row->isActive;
				$this->user->username = $row->username;
				$this->user->isAuthenticated = 1;
				//$this->user->userGroup = $row->user_group;
				$this->user->access = $row->access;
				
				
				$this->session->set_userdata($this->user );			
				
				//update last login field with current value
				$this->db->query("update user set `last_login` = NOW() where `user_id` = '".$this->user->userId."'");
				
				$return = true;
			} else {
				$userArray = array(
					'accessBlocked' => 'yes',
					);
				$this->session->set_userdata($userArray);
				
				$return = false;
			}
			
		} else {
			$userArray = array(
				'accessBlocked' => '',
				);
			$this->session->set_userdata($userArray);
			$return = false;
		}
		
		return $return;
	}
	
	// Validate a user from the regular login screen
	function validateUser() {
		
		$query = 'SELECT user.*, access.*, user_access.* '.
				' FROM user, access, user_access' .
				' WHERE user.email = \'' . trim($this->input->post('login_email')) . '\'' .
				' AND user.password = \'' . md5( trim($this->input->post('login_password')) ) . '\'' .
				' AND user.user_id = user_access.user_id' .
				' AND user_access.access_id = access.access_id';
		
		log_message('debug', $query);
		
		$result = $this->db->query($query);
		
		$return = false;
		if ($result->num_rows() > 0) {
			
			$row = $result->row();
			
			if ($row->isActive == 1) {
				
				$this->load->library('UserLib');
				
				$this->user->userId = $row->user_id;
				$this->user->email = $row->email;
				$this->user->zipcode = $row->zipcode;
				$this->user->firstName = $row->first_name;
				$this->user->isActive = $row->isActive;
				$this->user->username = $row->username;
				$this->user->isAuthenticated = 1;
				//$this->user->userGroup = $row->user_group;
				//$this->user->userGroupId = $row->user_group_id;
				$this->user->access = $row->access;
				$this->user->accessId = $row->access_id;
				
				$remember = $this->input->post('remember');
				if ($remember == 'on') {
					$baseUrl = base_url();
					$url = parse_url ($baseUrl);
					$sData = serialize($this->user);
					$cookie = array(
		                   'name'   => 'userObj',
		                   'value'  => $sData,
		                   'expire' => time()+60*60*24*30*365,
		                   'domain' => $url['host'],
		                   'path'   => '/',
		                   'prefix' => '',
		               );
					set_cookie($cookie);
				}
				
				$this->session->set_userdata($this->user);
				
				//update last login field with current value
				$this->db->query("update user set `last_login` = NOW() where `user_id` = '".$this->user->userId."'");
				
				$return = true;
			} else {
				$userArray = array(
					'accessBlocked' => 'yes',
					);
				$this->session->set_userdata($userArray);
				
				$return = false;
			}
			
		} else {
			
			$userArray = array(
				'accessBlocked' => '',
				);
			$this->session->set_userdata($userArray);
			$return = false;
		}
		
		return $return;
	}
	
	
	
}



?>