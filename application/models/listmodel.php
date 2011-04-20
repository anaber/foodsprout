<?php

class ListModel extends Model{
	public $tab;
	
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
	
	function buildInfoPagingLinks($params, $count = '') {
		if ( !isset($count) ) {
			$count = '';
		}
		
		$html = '';
		
		$html = '<div style="float:left; width:150px;" id = "numRecords'.$count.'">' . $this->drawNumRecords($params) . '</div>
		
		<div style="float:left; width:250px;" id = "pagingLinks'.$count.'" align = "center">
			' . $this->drawPagingLinks($params, $count) . '
		</div>
		
		<div style="float:left; width:175px;" id = "recordsPerPage'.$count.'" align = "right">
			' . $this->drawRecordsPerPage($params, $count) . '
		</div>';
		
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
	
	function drawRecordsPerPage($params, $count = '') {
		$str = '';
		$str .=  'Items per page: ';
		
		if ($params['perPage'] == 10) {
			$str .= '<strong>10</strong> | ';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '10') . '" id = "10PerPage'.$count.'">10</a> | ';
		}
		
		if ($params['perPage'] == 20) {
			$str .= '<strong>20</strong> | ';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '20') . '" id = "20PerPage'.$count.'">20</a> | ';
		}
		
		if ($params['perPage'] == 40) {
			$str .= '<strong>40</strong> | ';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '40') . '" id = "40PerPage'.$count.'">40</a> | ';
		}
		
		if ($params['perPage'] == 50) {
			$str .= '<strong>50</strong>';
		} else {
			$str .= '<a href="' . $this->buildUrl($params, 'pp', '50') . '" id = "50PerPage'.$count.'">50</a>';
		}
		
		return $str;
	}
	
	function drawPagingLinks($params, $count = '') {
		
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
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['firstPage']) . '" id = "imgFirst'.$count.'">First</a> &nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['previousPage']) . '" id = "imgPrevious'.$count.'">Previous</a> ';
		$str .= '&nbsp;&nbsp;&nbsp; Page ' . ($page['currentPage']+1) . ' of ' . $params['totalPages'] . '&nbsp;&nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['nextPage']) . '" id = "imgNext'.$count.'">Next</a> &nbsp;&nbsp;';
		$str .= '<a href="' . $this->buildUrl($params, 'p', $page['lastPage']) . '" id = "imgLast'.$count.'">Last</a>';
		
		return $str;
	}
	
	function buildUrl($params, $qs = null, $value = null, $tab = null) {
		$producerUrl = $this->input->post('producerUrl');
		
		if ($producerUrl) {
			$url = $producerUrl;
		} else {
			$uri1 = $this->uri->segment(1);
			if ($uri1 == 'sustainable') {
				$uri2 = $this->uri->segment(2);
				$uri3 = $this->uri->segment(3);
			} else {
				$uri2 = $this->uri->segment(2);
				$uri3 = '';//$this->uri->segment(3);
			}
			$url = '/' . $uri1 . ($uri2 ? '/' . $uri2 : '') . ($uri3 ? '/' . $uri3 : '');
		}
		
		$queryString = $this->buildQueryString($params, $qs, $value);
		
		$url .= ($queryString ? '?' . $queryString : '') ;
		//echo $url . "<br />";
		return $url;
	}
	
	function buildQueryString($params, $qs = null, $value = null) {
		$tab = $this->tab;
		
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
		
		if ($tab == '') {
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
		}
		if ($params['q'] ) {
			$queryString .= '&q=' . $params['q'];
		} else {
			$queryString .= '&q=';
		}
		
		if ($tab) {
			$queryString .= '&tab=' . $tab;
		} else {
			if (isset($params['city']) ) {
				$queryString .= '&city=' . $params['city'];
			} else {
				$queryString .= '&city=';
			}
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
				'	<div class = "listing-information">' . "\n";
				
				if ($farm->farmType) {
					$html .=
					'		<b>Livestock:</b> ' . "\n";
					$html .= $farm->farmType;
				}
				
				if ($farm->farmCrop) {
					$html .=
					'		<br /><b>Crop:</b> ' . "\n";
					$html .= $farm->farmCrop;
				}
				
				if ( count($farm->certifications) > 0 ) {
					$html .=
					'		<br /><b>Certification:</b> ' . "\n";
					foreach($farm->certifications as $j => $certification) {
						if ($j == 0) {
							$html .= $certification->certification;
						} else {
							$html .= ', ' . $certification->certification;
						}
					}
				}
				
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
	
	function buildSupplierList($suppliers, $producerName, $producerType) {
		$html = '';
		if ($suppliers['param']['numResults'] > 0) {
			foreach($suppliers['results'] as $key => $supplier) {
				
				
				$html .=
				'<div style="overflow:auto; padding-bottom:10px;">' . "\n" .
				'	<div class = "listing-supplier-header">' . "\n";
				
				if ($supplier->customUrl) {
					$html .= '	<a href="/' . $supplier->supplierType . '/' . $supplier->customUrl . '" style="font-size:13px;text-decoration:none;">'. $supplier->supplierName .'</a>' . "\n";
				} else {
					$html .= '	<a href="/' . $supplier->supplierType . '/view/' . $supplier->supplierId . '" style="font-size:13px;text-decoration:none;">'. $supplier->supplierName .'</a>' . "\n";
				}
				$html .=
				'		<div class = "clear"></div>' . "\n" .
				'	</div>' . "\n" .
				'	<div class = "clear"></div>' . "\n";
					
				$html .= 
				'	<div class = "listing-supplier-information">' . "\n";
				$html .= '<b>Type:</b> '. $supplier->supplierType;
				$html .= 
				'	</div>' . "\n" . 
				'	<div class = "listing-address-title">' . "\n".
				'		<b>Address:</b>' . "\n".
				'	</div>' . "\n" .
				'	<div class = "listing-address">' . "\n";
				
				foreach ($supplier->addresses as $j => $address) {
					if ($j == 0) {
						$html .= $address->displayAddress ;
					} else {
						$html .= "<br /><br />" . $address->displayAddress ;
					}
				};
				
				$html .= 
				'	</div>' . "\n";
				$html .=
				'</div>' . "\n" .
				'<div class = "clear"></div>' . "\n"
				;
			}
		} else {
			$html = $this->addZeroInfoResult('supplier', $producerName, $producerType);
		}
		return $html;
	}
	
	function buildSupplieeList($suppliees, $producerName, $producerType) {
		$html = '';
		if ($suppliees['param']['numResults'] > 0) {
			foreach($suppliees['results'] as $key => $company) {
				
				
				$html .=
				'<div style="overflow:auto; padding-bottom:10px;">' .
				'	<div class = "listing-supplier-header">';
				
				if ($company->customUrl) {
					$html .= '	<a href="/' . $company->type . '/' . $company->customUrl . '" style="font-size:13px;text-decoration:none;">'. $company->companyName .'</a>';
				} else {
					$html .= '	<a href="/' . $company->type . '/view/' . $company->companyId . '" style="font-size:13px;text-decoration:none;">'. $company->companyName .'</a>';
				}
				$html .=
				'		<div class = "clear"></div>'.
				'	</div>' .
				'	<div class = "clear"></div>';
					
				$html .= 
				'	<div class = "listing-supplier-information">';
				$html .= '<b>Type:</b> '. $company->type;
				$html .= 
				'	</div>' .
				'	<div class = "listing-address-title">'.
				'		<b>Address:</b>'.
				'	</div>' .
				'	<div class = "listing-address">';
				
				foreach ($company->addresses as $j => $address) {
					if ($j == 0) {
						$html .= $address->displayAddress ;
					} else {
						$html .= "<br /><br />" . $address->displayAddress ;
					}
				};
				
				$html .= 
				'	</div>';
				$html .=
				'</div>' .
				'<div class = "clear"></div>'
				;
			}
		} else {
			$html = $this->addZeroInfoResult('supplier', $producerName, $producerType);
		}
		return $html;
	}
	
	function addZeroInfoResult($type, $producerName, $producerType = null) {
		$html =
		'	<div class = "zero-result-box">';
		
		$html .= 'We are currently working on adding ';
		
		if ($type == 'supplier') {
			if ($producerType == 'farmers_market') {
				$html .= 'farms';	
			} else {
				$html .= 'suppliers';
			}
		} else if ($type == 'menu') {
			$html .= 'products';
		} else if ($type == 'comment') {
			$html .= 'comments';
		} else if ($type == 'photo') {
			$html .= 'photos';
		}
		
		$html .= ' for "' . $producerName . '". All viewers of the site may also update data like Wikipedia. Feel free to add ';
		
		if ($type == 'supplier') {
			$html .= '<a href="#" id = "addSupplier2" style="font-size:13px;text-decoration:none;">';
			if ($producerType == 'farmers_market') {
				$html .= 'farms';	
			} else {
				$html .= 'suppliers';
			}
			$html .= '</a>';
		} else if ($type == 'menu') {
			$html .= '<a href="#" id = "addMenu2" style="font-size:13px;text-decoration:none;">products</a>';
		} else if ($type == 'comment') {
			$html .= 'comments';
		} else if ($type == 'photo') {
			$html .= 'photos';
		}
		
		$html .=
		'	</div>'.
		'	<div class = "clear"></div>';
		
		return $html;
	}
	
	function buildMenuList($menus, $producerName, $producerType) {
		$html = '';
		if ($menus['param']['numResults'] > 0) {
			foreach($menus['results'] as $key => $menu) {
				
				
				$html .=	
				'<div class="menuitem">';
				//html +=	'	<div class="menuitemimg"><img src="/img/products/burger.jpg" width="132" height="107" alt="receipe" /></div>';
				
				if ($menu->image) {
					$html .=	'	<div class="menuitemimg">';
					$html .=	'<img src="' . $menu->image . '" width="132" height="107" alt="receipe" />';
					$html .= '	</div>';
				}
				
				$html .=	'	<div class="menuitemname">' . $menu->productName . '</div>';
				$html .=	'	<div class="menuitemdetails">' . $menu->ingredient . '</div>';
				$html .=
				'</div>' .
				'<div class = "clear"></div>'
				;
			}
		} else {
			$html = $this->addZeroInfoResult('menu', $producerName, $producerType);
		}
		return $html;
	}
	
	function buildCommentList($comments, $producerName, $producerType) {
		$html = '';
		if ($comments['param']['numResults'] > 0) {
			foreach($comments['results'] as $key => $comment) {
				
				
				$html .=
				'	<div class = "listing-comment"><strong>' . $comment->firstName . ':</strong>' . 
				'		&nbsp;' . $comment->comment . 
				'		<br /><div style="font-size:11px;font-weight:bold;">On ' . $comment->addedOn . '</div>' .
				'	</div>' .
				'	<div class = "clear"></div>' . 
				'	<hr size = "1" class = "listing-dash-line">' . 
				'	<div class = "clear"></div>';
			}
			$html .= '<div id="divNewComment"></div>'; 
		} else {
			$html = $this->addZeroInfoResult('comment', $producerName, $producerType);
		}
		return $html;
	}
	
	function buildPhotoList($photos, $producerName, $producerType) {
		$html = '';
		$html .= '<div id="gallery">'; 
		if ($photos['param']['numResults'] > 0) {
			$i = 0;
			foreach($photos['results'] as $key => $photo) {
				
				$i++;
	
				if ($i%3 == 0) {
				$html .= 
					'<div class="portfolio_sites flt"  style = "margin-left:14px;">';
				} else {
				$html .= 
					'<div class="portfolio_sites mar_rt_45 flt"  style = "margin-left:14px;">';
				}
				
				$html .=
				'	<div class="porffoilo_img" align = "center">' .
				'		<a href="' . $photo->photo . '" rel = "lightbox" title="' . ($photo->description ? $photo->description : '') . '" style = "text-decoration:none;">' . 
				'	        <img src="' . $photo->thumbPhoto . '" width="137" height="92" alt="" border = "0" /> ' .
				'	    </a>' .
				'	</div> ' .
				'	<div class="porffoilo_content" style = "font-size:11px;">' .
						($photo->title ? $photo->title . '<br />' : '') . 'By: <b>' . $photo->firstName . '</b><br />on ' . $photo->addedOn .
				'	</div>' .
				'</div>';
			}
			$html .=
			'<div class = "clear"></div>' . 
			'<hr size = "1" class = "flt listing-dash-line">' .
			'<div class = "clear"></div>';
			
		} else {
			$html = $this->addZeroInfoResult('photo', $producerName, $producerType);
		}
		$html .= '</div>';
		$html .= '<div class = "clear"></div>';
		return $html;
	}
	
	
}



?>