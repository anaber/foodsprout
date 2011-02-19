<?php

class ListModel extends Model{

	function buildRestaurantList($restaurants) {
		$html = '';
		foreach($restaurants['results'] as $key => $restaurant) {
			
			$html .=
			'<div style="overflow:auto; padding-bottom:10px;">' . "\n" .
			'	<div class = "listing-header">'. "\n";
			
			if ($restaurant->customUrl ) {
				$html .= '<div style = "float:left;"><a href="/restaurant/' . $restaurant->customUrl . '" id = "'. $restaurant->restaurantId .'" style="text-decoration:none;">'. $restaurant->restaurantName .'</a></div>' . "\n";
			} else {
				$html .= '<div style = "float:left;"><a href="/restaurant/view/' . $restaurant->restaurantId . '" id = "'. $restaurant->restaurantId .'" style="text-decoration:none;">'. $restaurant->restaurantName .'</a></div>' . "\n";
			}	
			
			if ($restaurant->claimsSustainable == 1) {
				$html .= '<div style = "float:right;padding-right:5px;"><img src = "/img/leaf-small.png"></div>' . "\n";
			}
			
			$html .=
			'		<div class = "clear"></div>'. "\n" .
			'	</div>' . "\n" .
			'	<div class = "clear"></div>' . "\n";
			$html .=
			'	<div class = "listing-information">' . "\n" .
			'		<b>Cuisine:</b> ' . "\n";
			
			
			foreach ($restaurant->cuisines as $j => $cuisine) {
				if ($j == 0) {
					$html .= $cuisine->cuisine;
				} else {
					$html .= ",&nbsp;" . $cuisine->cuisine;
				}
			}
			
			$html .= 
			'	</div>' . "\n" .
			'	<div class = "listing-address-title">'. "\n" .
			'		<b>Address:</b>'. "\n" .
			'	</div>' .
			'	<div class = "listing-address">' . "\n";

			foreach ($restaurant->addresses as $j => $address) {
				if ($j == 0) {
					$html .= '<a href="#" id = "map_'. $address->addressId .'" style="font-size:13px;text-decoration:none;">' . $address->displayAddress . '</a>' . "\n";
				} else {
					$html .= "<br /><br />" . '<a href="#" id = "map_'. $address->addressId .'" style="font-size:13px;text-decoration:none;">' . $address->displayAddress . '</a>' . "\n";
				}
			}
			
			$html .= 
			'	</div>' . "\n" .
			'	<div class = "clear"></div>' . "\n";
			$html .=
			'</div>' . "\n".
			'<div class = "clear"></div>' . "\n"
			;
		}
		return $html;
	}
	
	function buildPagingLinks($params) {
		$html = '';
		
		$html = '<div style="float:left; width:172px;" id = "numRecords">' . $this->drawNumRecords($params) . '</div>
		
		<div style="float:left; width:250px;" id = "pagingLinks" align = "center">
			' . $this->drawPagingLinks($params) . '
		</div>
		
		<div style="float:left; width:195px;" id = "recordsPerPage" align = "right">
			' . $this->drawRecordsPerPage($params) . '
		</div>';
		
		return $html;
	}
	
	function drawNumRecords($params) {
		$str = '';
		
		if ($params['numResults'] == 0) {
			$str .= 'Records 0' . '-' . $params['end'] . ' of ' . $params['numResults'];
		} else {
			$str .= 'Records ' . $params['start'] . '-' . $params['end'] . ' of ' . $params['numResults'];
		}
		
		return $str;
	}
	
	function drawRecordsPerPage($params) {
		$str = '';
		$str .=  'Items per page: ';
		
		if ($params['perPage'] == 10) {
			$str .= '<strong>10</strong> | ';
		} else {
			$str .= '<a href="#" id = "10PerPage">10</a> | ';
		}
		
		if ($params['perPage'] == 20) {
			$str .= '<strong>20</strong> | ';
		} else {
			$str .= '<a href="#" id = "20PerPage">20</a> | ';
		}
		
		if ($params['perPage'] == 40) {
			$str .= '<strong>40</strong> | ';
		} else {
			$str .= '<a href="#" id = "40PerPage">40</a> | ';
		}
		
		if ($params['perPage'] == 50) {
			$str .= '<strong>50</strong>';
		} else {
			$str .= '<a href="#" id = "50PerPage">50</a>';
		}
		
		return $str;
	}
	
	function drawPagingLinks($params) {
		$str = '';
		$str .= '<a href="#" id = "imgFirst">First</a> &nbsp;&nbsp;';
		$str .= '<a href="#" id = "imgPrevious">Previous</a> ';
		$str .= '&nbsp;&nbsp;&nbsp; Page ' . ($params['page']+1) . ' of ' . $params['totalPages'] . '&nbsp;&nbsp;&nbsp;';
		$str .= '<a href="#" id = "imgNext">Next</a> &nbsp;&nbsp;';
		$str .= '<a href="#" id = "imgLast">Last</a>';
		
		return $str;
	}
}



?>