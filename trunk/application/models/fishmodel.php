<?php

class FishModel extends Model{
	
	// List all the fish in the database
	function list_fish()
	{
		$query = "SELECT * FROM fish ORDER BY fish_name";
		
		log_message('debug', "FishModel.list_fish : " . $query);
		$result = $this->db->query($query);
		
		$fishes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('FishLib');
			unset($this->fishLib);
			
			$this->fishLib->fishId = $row['fish_id'];
			$this->fishLib->fishName = $row['fish_name'];
			
			$fishes[] = $this->fishLib;
			unset($this->fishLib);
		}
		return $fishes;
	}
	
	function addFish() {
		$return = true;
		
		$query = "SELECT * FROM fish WHERE fish_name = \"" . $this->input->post('fishName') . "\"";
		log_message('debug', 'FishModel.addFish : Try to get duplicate Fish record : ' . $query);
		
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$query = "INSERT INTO fish (fish_id, fish_name)" .
					" values (NULL, \"" . $this->input->post('fishName') . "\")";
			log_message('debug', 'FishModel.addfish : Insert Fish : ' . $query);
			
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
	
	function getFishFromId($fishId) {
		
		$query = "SELECT * FROM fish WHERE fish_id = " . $fishId;
		log_message('debug', "FishModel.getFishFromId : " . $query);
		$result = $this->db->query($query);
		
		$fish = array();
		
		$this->load->library('FishLib');
		
		$row = $result->row();
		
		$this->fishLib->fishId = $row->fish_id;
		$this->fishLib->fishName = $row->fish_name;
		
		return $this->fishLib;
	}
	
	function updateFish() {
		$return = true;
		
		$query = "SELECT * FROM fish WHERE fish_name = \"" . $this->input->post('fishName') . "\" AND fish_id <> " . $this->input->post('fishId');
		log_message('debug', 'FishModel.updateFish : Try to get Duplicate record : ' . $query);
			
		$result = $this->db->query($query);
		
		if ($result->num_rows() == 0) {
			
			$data = array(
						'fish_name' => $this->input->post('fishName'), 
					);
			$where = "fish_id = " . $this->input->post('fishId');
			$query = $this->db->update_string('fish', $data, $where);
			
			log_message('debug', 'FishModel.updateFish : ' . $query);
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