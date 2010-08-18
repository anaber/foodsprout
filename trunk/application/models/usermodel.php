<?php

class UserModel extends Model{
	
	
	// Used to validate password before updating password in user settings
	function validate_pass()
	{
		$this->db->where('password', md5($this->input->post('old_password')));
		$this->db->where('userid', $this->session->userdata('userid'));
		$query = $this->db->get('user');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	// Used to validate password before updating password in user settings
	function update_pass()
	{
		$data = array(
		               'password' => md5($this->input->post('newpass1'))
		            );

		$this->db->where('userid', $this->session->userdata('userid'));
		$query = $this->db->update('user', $data);
	}
	
	// Add a new user to the database
	function createUser() {
		$return = true;
		
		$email = $this->input->post('email');
		
		if (!empty($email) ) {
		
			$query = "SELECT * FROM user WHERE email = \"" . $email . "\"";
			log_message('debug', 'UserModel.createUser : Try to get duplicate User record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				
				$new_user_insert_data = array(
					'first_name' => $this->input->post('firstname'),
					'email' => $email,
					'zipcode' => $this->input->post('zipcode'),
					'password' => md5($this->input->post('password')),
					'register_ipaddress' => getRealIpAddr(),//$_SERVER['REMOTE_ADDR'],
					'isActive' => 1
				);
	
				log_message('debug', $new_user_insert_data);
				
				$insert = $this->db->insert('user', $new_user_insert_data);
				
				$return = false;
				
				if($insert) {
					$userId = $this->db->insert_id();
					$new_user_group_insert_data = array(
						'user_id' =>  $userId,
						'user_group_id' => 2
					);
					
					log_message('debug', $new_user_group_insert_data);
					
					$insert = $this->db->insert('user_group_member', $new_user_group_insert_data);
					
					$return = true;
					
					$this->load->library('UserLib');
					
					$this->user->userId = $userId;
					$this->userLib->email = $this->input->post('email');
					$this->userLib->zipcode = $this->input->post('zipcode');
					$this->userLib->firstName = $this->input->post('firstname');
					$this->userLib->isActive = 1;
					//$this->user->screenName = $row->screen_name;
					$this->userLib->isAuthenticated = 1;
					//$this->user->userGroup = $row->user_group;
					
					$this->session->set_userdata($this->userLib );
					
					$return = true;
				} else  {
					$return = false;
				}
				
			} else {
				
				$GLOBALS['error'] = 'duplicate';
				$return = false;
			}
		} else {
			$return = false;
		}
		
		return $return;
	}
	
	// Get all the users of the database
	function get_user()
	{
		
		$this->db->where('email', $this->input->post('email'));
		$query = $this->db->get('user');
		
		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	
	// Get the data from the current user that is logged into a session
	function get_current_user()
	{
		$this->db->from('user');
		$this->db->where('email', $this->session->userdata('email'));
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
	}
	
	function getUserFromId($userId) {
		
		$query = "SELECT user.*, user_group.user_group, user_group.user_group_id " .
				" FROM user, user_group, user_group_member " .
				" WHERE user.user_id = " . $userId . 
				" AND user.user_id = user_group_member.user_id" .
				" AND user_group.user_group_id = user_group_member.user_group_id ";
				
		log_message('debug', "UserModel.getUserFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('UserLib');
		
		$row = $result->row();
		
		if ($row) {
			$this->UserLib->userId = $row->user_id;
			$this->UserLib->email = $row->email;
			$this->UserLib->firstName = $row->first_name;
			$this->UserLib->screenName = $row->screen_name;
			$this->UserLib->userGroup = $row->user_group;
			$this->UserLib->zipcode = $row->zipcode;
			$this->UserLib->userGroupId = $row->user_group_id;
			
			return $this->UserLib;
		} else {
			return;
		}
	}
	
	function updateUserSettings() {
		$return = true;
		
		$query = "SELECT * FROM user WHERE email = \"" . $this->input->post('email') . "\" AND user_id <> " . $this->session->userdata('userId');
		log_message('debug', 'UserModel.updateUserSettings : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'email' => $this->input->post('email'), 
						'screen_name' => $this->input->post('screenName'),
						'first_name' => $this->input->post('firstName'),
						'zipcode' => $this->input->post('zipcode'),
					);
			$where = "user_id = " . $this->session->userdata('userId');
			$query = $this->db->update_string('user', $data, $where);
			
			log_message('debug', 'UserModel.updateUserSettings : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
				
		return $return;
	}
	
	function updatePassword() {
		$return = true;
		
		$query = "SELECT * FROM user WHERE password = \"" . md5($this->input->post('currentPassword')) . "\" AND user_id = " . $this->session->userdata('userId');
		log_message('debug', 'UserModel.updatePassword : Try to get Duplicate record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() > 0) {
			
			
			$data = array(
						'password' => md5($this->input->post('newPassword')), 
					);
			$where = "user_id = " . $this->session->userdata('userId');
			$query = $this->db->update_string('user', $data, $where);
			
			log_message('debug', 'UserModel.updatePassword : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
		} else {
			$GLOBALS['error'] = 'wrong_password';
			$return = false;
		}
		
		return $return;
	}
	
	
}



?>