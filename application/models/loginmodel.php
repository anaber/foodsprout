<?php

class LoginModel extends Model{
	
	function validateAdmin()
	{
		$query = 'SELECT user.*, user_group.*, user_group_member.* '.
				' FROM user, user_group, user_group_member' .
				' WHERE user.email = \'' . trim($this->input->post('email')) . '\'' .
				' AND user.password = \'' . md5( trim($this->input->post('password')) ) . '\'' .
				' AND user.user_id = user_group_member.user_id' .
				' AND user_group_member.user_group_id = user_group.user_group_id' .
				' AND user_group.user_group = \'admin\' ';
		
		log_message('debug', $query);
		
		$result = $this->db->query($query);
		
		$return = false;
		if ($result->num_rows() > 0) {
			
			$row = $result->row();
			
			if ($row->isActive == 1) {
				
				$this->load->library('user');
				
				$this->user->userId = $row->user_id;
				$this->user->email = $row->email;
				$this->user->zipcode = $row->zipcode;
				$this->user->firstName = $row->first_name;
				//Currently we do not require lastname
				//$this->user->lastName = $row->last_name;
				$this->user->isActive = $row->isActive;
				$this->user->screenName = $row->screen_name;
				$this->user->isAuthenticated = 1;
				$this->user->userGroup = $row->user_group;
				
				$this->session->set_userdata($this->user );
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
	
	function validate()
	{
		$query = 'SELECT user.*, user_group.*, user_group_member.* '.
				' FROM user, user_group, user_group_member' .
				' WHERE user.email = \'' . trim($this->input->post('email')) . '\'' .
				' AND user.password = \'' . md5( trim($this->input->post('password')) ) . '\'' .
				' AND user.user_id = user_group_member.user_id' .
				' AND user_group_member.user_group_id = user_group.user_group_id';
		
		log_message('debug', $query);
		
		$result = $this->db->query($query);
		
		$return = false;
		if ($result->num_rows() > 0) {
			
			$row = $result->row();
			
			if ($row->isActive == 1) {
				
				$this->load->library('user');
				
				$this->user->userId = $row->user_id;
				$this->user->email = $row->email;
				$this->user->zipcode = $row->zipcode;
				$this->user->firstName = $row->first_name;
				$this->user->lastName = $row->last_name;
				$this->user->isActive = $row->isActive;
				$this->user->screenName = $row->screen_name;
				$this->user->isAuthenticated = 1;
				$this->user->userGroup = $row->user_group;
				
				$this->session->set_userdata($this->user );
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