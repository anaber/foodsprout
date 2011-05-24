<?php

class PortletModel extends Model{
	
	function getPortletPositon($userId, $page) {
		global $PORTLET;
		$portlet = array();
		
		$query = 'SELECT * ' .
				' FROM portlet_position ' .
				' WHERE user_id = ' . $userId . 
				' AND page = \''.$page.'\'';
				
		log_message('debug', 'PortletModel.getPortletPositon : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			$portlet = $PORTLET[$page];
		} else {
			$row = $result->row();
			
			$portlet['column_1'] = ($row->column_1 ? explode(',', $row->column_1) : array()) ;
			$portlet['column_2'] = ($row->column_2 ? explode(',', $row->column_2) : array()) ;
		}
		return $portlet;	
	}
	
	function savePortletPositon() {
		$return = true;
		
		$userId = $this->session->userdata('userId');
		$page = $this->input->post('page');
		
		$column_1 = $this->input->post('column_1');
		if (count($column_1) > 0) {
			$column_1 = implode(',', $column_1);
		} else {
			$column_1 = '';
		}
		$column_2 = $this->input->post('column_2');
		if (count($column_2) > 0) {
			$column_2 = implode(',', $column_2);
		} else {
			$column_2 = '';
		}
		
		$query = 'SELECT * ' .
				' FROM portlet_position ' .
				' WHERE user_id = ' . $userId . 
				' AND page = \''.$page.'\'';
				
		log_message('debug', 'PortletModel.getPortletPositon : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			// INSERT
			$query = 'INSERT INTO portlet_position (position_id, page, user_id, column_1, column_2)' .
					' VALUES (NULL, \'' . $page . '\', ' . $userId . ', \'' . $column_1 . '\', \'' . $column_2 . '\')';
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		} else {
			// UPDATE
			$data = array(
						'column_1' => (!empty($column_1) ? $column_1 : NULL) ,
						'column_2' => (!empty($column_2) ? $column_2 : NULL),
			);
			$where = 'user_id = ' . $userId . ' AND page = \''.$page.'\'';
			$query = $this->db->update_string('portlet_position', $data, $where);

			log_message('debug', 'PortletModel.savePortletPositon : ' . $query);
			if ( $this->db->query($query) ) {
				$return = true;
			} else {
				$return = false;
			}
		}
		return $return;	
	}

}



?>