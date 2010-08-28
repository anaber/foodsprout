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
?>