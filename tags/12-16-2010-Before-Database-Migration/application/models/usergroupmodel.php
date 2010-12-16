<?php

class UsergroupModel extends Model{
	
	// List all the usergroup in the database
	function list_usergroup()
	{
		$query = "SELECT * FROM user_group ORDER BY user_group";
		
		log_message('debug', "UsergroupModel.list_usergroup : " . $query);
		$result = $this->db->query($query);
		
		$usergroups = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('UsergroupLib');
			unset($this->usergroupLib);
			
			$this->usergroupLib->usergroupId = $row['user_group_id'];
			$this->usergroupLib->usergroupName = $row['user_group'];
			
			$usergroups[] = $this->usergroupLib;
			unset($this->usergroupLib);
		}
		return $usergroups;
	}
	
	function addUsergroup() {
		$return = true;
		
		$query = "SELECT * FROM user_group WHERE user_group = \"" . $this->input->post('usergroupName') . "\"";
		log_message('debug', 'UsergroupModel.addUsergroup : Try to get duplicate Usergroup record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO user_group (user_group_id, user_group)" .
					" values (NULL, \"" . $this->input->post('usergroupName') . "\")";
			log_message('debug', 'UsergroupModel.addUsergroup : Insert Usergroup : ' . $query);
			
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
			
			$return = true;
		} else {
			$GLOBALS['error'] = 'duplicate';
			$return = false;
		}
		
		return $return;	
	}
	
	function getUsergroupFromId($usergroupId) {
		
		$query = "SELECT * FROM user_group WHERE user_group_id = " . $usergroupId;
		log_message('debug', "UsergroupModel.getUsergroupFromId : " . $query);
		$result = $this->db->query($query);
		
		$usergroup = array();
		
		$this->load->library('UsergroupLib');
		
		$row = $result->row();
		
		$this->usergroupLib->usergroupId = $row->user_group_id;
		$this->usergroupLib->usergroupName = $row->user_group;
		
		return $this->usergroupLib;
	}
	
	function updateUsergroup() {
		$return = true;
		
		$query = "SELECT * FROM user_group WHERE user_group = \"" . $this->input->post('usergroupName') . "\" AND user_group_id <> " . $this->input->post('usergroupId');
		log_message('debug', 'UsergroupModel.updateUsergroup : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'user_group' => $this->input->post('usergroupName'), 
					);
			$where = "user_group_id = " . $this->input->post('usergroupId');
			$query = $this->db->update_string('user_group', $data, $where);
			
			log_message('debug', 'UsergroupModel.updateUsergroup : ' . $query);
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
	
}



?>