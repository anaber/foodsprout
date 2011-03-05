<?php

class ListModel extends Model{

	function buildRestaurantList($restaurants) {
		$html = '';
		if ($restaurants['param']['numResults'] > 0) {
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
		} else {
			$html = $this->zeroResults();
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
		$this->buildUrl($params);
		
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
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '10') . '" id = "10PerPage">10</a> | ';
		}
		
		if ($params['perPage'] == 20) {
			$str .= '<strong>20</strong> | ';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '20') . '" id = "20PerPage">20</a> | ';
		}
		
		if ($params['perPage'] == 40) {
			$str .= '<strong>40</strong> | ';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '40') . '" id = "40PerPage">40</a> | ';
		}
		
		if ($params['perPage'] == 50) {
			$str .= '<strong>50</strong>';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '50') . '" id = "50PerPage">50</a>';
		}
		
		return $str;
	}
	
	function drawPagingLinks($params) {
		
		$lastPage = $params['lastPage'];//floor($params['numResults']/$params['perPage']);
		$currentPage = ($params['page'] > $lastPage ? $lastPage : $params['page']);
		$firstPage = '0';
		$previousPage = ( ($currentPage -1) < 0 ? 0 : ($currentPage -1));
		$nextPage = ( ($currentPage + 1 ) > $lastPage ? $lastPage : ($currentPage + 1) );
		
		$page = array (
			'firstPage' => $firstPage,
			'previousPage' => $previousPage,
			'currentPage' => $currentPage,
			'nextPage' => $nextPage,
			'lastPage' => $lastPage
		);
		//print_r_pre($page);
		$str = '';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['firstPage']) . '" id = "imgFirst">First</a> &nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['previousPage']) . '" id = "imgPrevious">Previous</a> ';
		$str .= '&nbsp;&nbsp;&nbsp; Page ' . ($page['currentPage']+1) . ' of ' . $params['totalPages'] . '&nbsp;&nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['nextPage']) . '" id = "imgNext">Next</a> &nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['lastPage']) . '" id = "imgLast">Last</a>';
		
		return $str;
	}
	
	function buildUrl($params, $qs = null, $value = null) {
		$uri1 = $this->uri->segment(1);
		if ($uri1 == 'sustainable') {
			$uri2 = $this->uri->segment(2);
			$uri3 = $this->uri->segment(3);
		} else {
			$uri2 = '';//$this->uri->segment(2);
			$uri3 = '';//$this->uri->segment(3);
		}
		$url = '/' . $uri1 . ($uri2 ? '/' . $uri2 : '') . ($uri3 ? '/' . $uri3 : '');
		
		$queryString = $this->buildQueryString($params, $qs, $value);
		
		$url .= ($queryString ? '?' . $queryString : '') ;
		return $url;
	}
	
	function buildQueryString($params, $qs = null, $value = null) {
		
		$queryString = '';
		
		if ($qs == 'pp') {
			$queryString .= 'p=0';
		} else {
			if ($qs == 'p') {
				$queryString .= 'p=' . $value;
			} else {
				$queryString .= 'p=' . $params['page'];
			}
		}
		
		if ($params['perPage'] ) {
			if ($qs == 'pp') {
				$queryString .= '&pp=' . $value;
			} else {
				$queryString .= '&pp=' . $params['perPage'];
			}
		} else {
			$queryString .= '&pp=';
		}
		
		if ($params['sort'] ) {
			if ($qs == 'sort') {
				$queryString .= '&sort=' . $value;
			} else {
				$queryString .= '&sort=' . $params['sort'];
			}
		} else {
			$queryString .= '&sort=';
		}
		
		if ($params['order'] ) {
			if ($qs == 'order') {
				$queryString .= '&order=' . $value;
			} else {
				$queryString .= '&order=' . $params['order'];
			}
		} else {
			$queryString .= '&order=';
		}
		
		if ($params['filter'] ) {
			if ($qs == 'f') {
				$queryString .= '&f=' . $value;
			} else {
				$queryString .= '&f=' . $params['filter'];
			}
		} else {
			$queryString .= '&f=';
		}
		
		if ($params['q'] ) {
			$queryString .= '&q=' . $params['q'];
		} else {
			$queryString .= '&q=';
		}
		
		if (isset($params['city']) ) {
			$queryString .= '&city=' . $params['city'];
		} else {
			$queryString .= '&city=';
		}
		
		return $queryString;
	}
	
	function buildFarmList($farms) {
		
		$html = '';
		if ($farms['param']['numResults'] > 0) {
			foreach($farms['results'] as $key => $farm) {
				
				$html .=
				'<div style="overflow:auto; padding-bottom:10px;">' . "\n" .
				'	<div class = "listing-header">'. "\n";
				
				if ($farm->customUrl ) {
					$html .= '<div style = "float:left;"><a href="/farm/' . $farm->customUrl . '" id = "'. $farm->farmId .'" style="text-decoration:none;">'. $farm->farmName .'</a></div>' . "\n";
				} else {
					$html .= '<div style = "float:left;"><a href="/farm/view/' . $farm->farmId . '" id = "'. $farm->farmId .'" style="text-decoration:none;">'. $farm->farmName .'</a></div>' . "\n";
				}	
				
				$html .=
				'		<div class = "clear"></div>'. "\n" .
				'	</div>' . "\n" .
				'	<div class = "clear"></div>' . "\n";
				$html .=
				'	<div class = "listing-information">' . "\n" .
				'		<b>Type:</b> ' . "\n";
				
				$html .= $farm->farmType;
				
				$html .= 
				'	</div>' . "\n" .
				'	<div class = "listing-address-title">'. "\n" .
				'		<b>Address:</b>'. "\n" .
				'	</div>' .
				'	<div class = "listing-address">' . "\n";
	
				foreach ($farm->addresses as $j => $address) {
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
		} else {
			$html = $this->zeroResults();
		}
		return $html;
	}
	
	
	function buildFarmersMarketList($farmersMarkets) {
		
		$html = '';
		
		if ($farmersMarkets['param']['numResults'] > 0) {
			foreach($farmersMarkets['results'] as $key => $farmersMarket) {
				
				$html .=
				'<div style="overflow:auto; padding-bottom:10px;">' . "\n" .
				'	<div class = "listing-header">'. "\n";
				
				if ($farmersMarket->customUrl ) {
					$html .= '<div style = "float:left;"><a href="/farmersmarket/' . $farmersMarket->customUrl . '" id = "'. $farmersMarket->farmersMarketId .'" style="text-decoration:none;">'. $farmersMarket->farmersMarketName .'</a></div>' . "\n";
				} else {
					$html .= '<div style = "float:left;"><a href="/farmersmarket/view/' . $farmersMarket->farmersMarketId . '" id = "'. $farmersMarket->farmersMarketId .'" style="text-decoration:none;">'. $farmersMarket->farmersMarketName .'</a></div>' . "\n";
				}	
				
				$html .=
				'		<div class = "clear"></div>'. "\n" .
				'	</div>' . "\n" .
				'	<div class = "clear"></div>' . "\n";
				$html .=
				'	<div class = "listing-address-title">'. "\n" .
				'		<b>Address:</b>'. "\n" .
				'	</div>' .
				'	<div class = "listing-address">' . "\n";
	
				foreach ($farmersMarket->addresses as $j => $address) {
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
			
		} else {
			$html = $this->zeroResults();
		}
		return $html;
	}
	
	function zeroResults() {
		$html =
			'<div style="overflow:auto; padding:0px; clear:left; margin-right:10px; padding-bottom:10px;" align = "center">' .
			'	<div style="float:left; width:600px; clear:left;padding-left:3px; padding-right:10px;font-size:13px;">No results found. Please retry with some other filter options.</div>' . 
			'</div>'
			;
		return $html;
	}
}



?>