<?php

class UserModel extends Model{
	
	private $errors = array();
	
	private function set_error($name, $value){
		
		$this->errors[$name] = $value;
		
	}
	
	public function get_error($name){
		
		return $this->errors[$name];
		
	}
	
	
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
		$username = $this->input->post('username');
		
		if (!empty($email) ) {
		
			$query = "SELECT * FROM user WHERE email = \"" . $email . "\" OR username = \"" . $username . "\"";
			log_message('debug', 'UserModel.createUser : Try to get duplicate User record : ' . $query);
			
			$result = $this->db->query($query);
			
			if ($result->num_rows() == 0) {
				
				$new_user_insert_data = array(
					'username' => $this->input->post('username'),
					// We insert the username as the first name because the user can later update their name field
					'first_name' => $this->input->post('username'),
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
					
					$this->userLib->userId = $userId;
					$this->userLib->email = $this->input->post('email');
					$this->userLib->zipcode = $this->input->post('zipcode');
					$this->userLib->username = $this->input->post('username');
					$this->userLib->firstName = $this->input->post('username');
					$this->userLib->isActive = 1;
					$this->userLib->isAuthenticated = 1;
					
					$this->session->set_userdata($this->userLib );
					
					$return = true;
				} else  {
					$return = false;
				}
				
			} else {
				
				$GLOBALS['error'] = 'duplicate';
				
				$this->set_error('create_user','duplicate');
				
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
			$this->UserLib->username = $row->username;
			$this->UserLib->userGroup = $row->user_group;
			$this->UserLib->zipcode = $row->zipcode;
			$this->UserLib->userGroupId = $row->user_group_id;
            $this->UserLib->defaultCity = $row->default_city;
			
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
                            'first_name' => $this->input->post('firstName'),
                            'zipcode' => $this->input->post('zipcode'),
                            'default_city' => $this->input->post('defaultcity')
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
			$GLOBALS['error'] = 'wrong_password'.$this->session->userdata('userId');
			$return = false;
		}
		
		return $return;
	}
	
	function getUsersJsonAdmin() {
		global $PER_PAGE;
		
		$p = $this->input->post('p'); // Page
		$pp = $this->input->post('pp'); // Per Page
		$sort = $this->input->post('sort');
		$order = $this->input->post('order');
		
		$q = $this->input->post('q');
		
		if ($q == '0') {
			$q = '';
		}
		
		$start = 0;
		$page = 0;
		
		
		$base_query = 'SELECT user.*' .
				' FROM user';
		
		$base_query_count = 'SELECT count(user_id) AS num_records' .
				' FROM user';
		$where = '';
		if (! empty ($q) ) {
		$where .= ' WHERE' 
				. '	email like "%' .$q . '%"'
				. ' OR user_id like "%' . $q . '%"';
		}
		$base_query_count = $base_query_count . $where;
		
		$query = $base_query_count;
		
		$result = $this->db->query($query);
		$row = $result->row();
		$numResults = $row->num_records;
		
		$query = $base_query . $where;
		
		if ( empty($sort) ) {
			$sort_query = ' ORDER BY email';
			$sort = 'email';
		} else {
			$sort_query = ' ORDER BY ' . $sort;
		}
		
		if ( empty($order) ) {
			$order = 'ASC';
		}
		
		$query = $query . ' ' . $sort_query . ' ' . $order;
		
		if (!empty($pp) && $pp != 'all' ) {
			$PER_PAGE = $pp;
		}
		
		if (!empty($pp) && $pp == 'all') {
			// NO NEED TO LIMIT THE CONTENT
		} else {
			
			if (!empty($p) || $p != 0) {
				$page = $p;
				$p = $p * $PER_PAGE;
				$query .= " LIMIT $p, " . $PER_PAGE;
				$start = $p;
				
			} else {
				$query .= " LIMIT 0, " . $PER_PAGE;
			}
		}
		
		log_message('debug', "UserModel.getUsersJsonAdmin : " . $query);
		$result = $this->db->query($query);
		
		$users = array();
		
		$CI =& get_instance();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('UserLib');
			unset($this->UserLib);
			
			$this->UserLib->userId = $row['user_id'];
			$this->UserLib->email = $row['email'];
			$this->UserLib->joinDate = $row['join_date'];
			$this->UserLib->firstName = $row['first_name'];
			$this->UserLib->zipcode = $row['zipcode'];
			
			$users[] = $this->UserLib;
			unset($this->UserLib);
		}
		
		if (!empty($pp) && $pp == 'all') {
			$PER_PAGE = $numResults;
		}
		
		$totalPages = ceil($numResults/$PER_PAGE);
		$first = 0;
		if ($totalPages > 0) {
			$last = $totalPages - 1;
		} else {
			$last = 0;
		}
		
		$params = requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, '', '');
		$arr = array(
			'results'    => $users,
			'param'      => $params,
	    );
	    
	    return $arr;
	}
	
	function resetpassword($email){
		
		$this->db->from('user');
		$this->db->where('email', $email);
		$query = $this->db->get();
		
		if($query->num_rows > 0){
			
			$password = substr(md5(rand(9999, 19000)), -8);
			
			$data = array( 'password' => md5($password) );

			$this->db->where('email', $email);
			$this->db->update('user', $data); 
			
			$this->set_error('password', $password);
			return TRUE;
			
		}else {
			
			$this->set_error('error', "email_not_found");
			return FALSE;
		}
		
	}

    function getDefaultCityByUserId($userId)
    {
        $q = $this->db->select('default_city')->from('user')->where('user_id', $userId)->get()->row();

        return ($q) ? $q->default_city : null;
    }

    function updateUserDefaultCity($defaultCity, $userId)
    {
        if (ctype_digit($userId))
        {
            $data = array('default_city' => $defaultCity);

            $this->db->update('user', $data, 'user_id = '.$userId);
        }
    }
}
?>