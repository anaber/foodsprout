<?php
function print_r_pre($ob){
	echo "<pre style=\"text-align: left;\">";
	print_r($ob);
	echo "</pre>";
}

function requestToParams($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel) {
	global $PER_PAGE;
	
	$param = array(
		'page'     		=> $page,
		'totalPages' 	=> $totalPages,
		'perPage'  		=> $PER_PAGE,
		'start'    		=> $start+1,
		'end'    		=> ( ($start + $PER_PAGE) > $numResults ? $numResults : ($start + $PER_PAGE) ) ,
		'firstPage'		=> $first,
		'lastPage'		=> $last,
		'numResults'  	=> $numResults,
		'sort'  		=> $sort,
		'order'  		=> $order,
		'q'  			=> $q,
		'filter'		=> $filter,
		'zoomLevel'		=> $mapZoomLevel,
	);
	return $param;
}

function requestToParams2($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel) {
	global $PER_PAGE_2;
	
	$param = array(
		'page'     		=> $page,
		'totalPages' 	=> $totalPages,
		'perPage'  		=> $PER_PAGE_2,
		'start'    		=> $start+1,
		'end'    		=> ( ($start + $PER_PAGE_2) > $numResults ? $numResults : ($start + $PER_PAGE_2) ) ,
		'firstPage'		=> $first,
		'lastPage'		=> $last,
		'numResults'  	=> $numResults,
		'sort'  		=> $sort,
		'order'  		=> $order,
		'q'  			=> $q,
		'filter'		=> $filter,
		'zoomLevel'		=> $mapZoomLevel,
	);
	return $param;
}

function requestToParams3($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius) {
	global $PER_PAGE;
	
	$param = array(
		'page'     		=> $page,
		'totalPages' 	=> $totalPages,
		'perPage'  		=> $PER_PAGE,
		'start'    		=> $start+1,
		'end'    		=> ( ($start + $PER_PAGE) > $numResults ? $numResults : ($start + $PER_PAGE) ) ,
		'firstPage'		=> $first,
		'lastPage'		=> $last,
		'numResults'  	=> $numResults,
		'sort'  		=> $sort,
		'order'  		=> $order,
		'q'  			=> $q,
		'filter'		=> $filter,
		'zoomLevel'		=> $mapZoomLevel,
		'radius'		=> $radius,
	);
	return $param;
}

function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) { 

	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	$dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);
	
	if ($unit == "K") {
		return ($miles * 1.609344); 
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
}

function prepareHeading ($company, $id, $crudEntity, $action) {
	$str = '';
	if ($action == 'add') {
		$str = 'Add ' . $crudEntity . ' for "' . $company . '"';
	} else if ($action == 'update') {
		$str = 'Update ' . $crudEntity . ' for "' . $company . '" - #' . $id;
	}
	
	return $str;
}


?>