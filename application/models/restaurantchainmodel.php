<?php

class RestaurantChainModel extends Model{
	
	function searchRestaurantChains($q) {
		$query = "SELECT restaurant_chain_id, restaurant_chain
					FROM restaurant_chain
					WHERE restaurant_chain like '$q%'
					ORDER BY restaurant_chain ";
		$restaurantChains = '';
		log_message('debug', "RestaurantChainModel.searchRestaurantChains : " . $query);
		$result = $this->db->query($query);
		foreach ($result->result_array() as $row) {
			$restaurantChains .= $row['restaurant_chain']."|".$row['restaurant_chain_id']."\n";
		}
		
		return $restaurantChains;
	}
	
}



?>