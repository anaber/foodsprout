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
	function create_user()
	{
		$new_user_insert_data = array(
			'first_name' => $this->input->post('firstname'),
			'email' => $this->input->post('email'),
			'zipcode' => $this->input->post('zipcode'),
			'password' => md5($this->input->post('password')),
			'register_ipaddress' => $_SERVER['REMOTE_ADDR'],
			'isActive' => 1
		);
		
		$insert = $this->db->insert('user', $new_user_insert_data);
		
		$return = false;
		
		if($insert)
		{
			//$this->load->library('user');
			
			$return = true;
		}
		else
		{
			$return = false;
		}
		
		//$return = true;
		
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
	
	
}



?>