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

function requestToParamsCitySearch($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $city) {
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
		'city'			=> $city,
		'zoomLevel'		=> $mapZoomLevel,
	);
	return $param;
}

function requestToParamsFarmersMarket($numResults, $start, $totalPages, $first, $last, $page, $sort, $order, $q, $filter, $mapZoomLevel, $radius, $city) {
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
		'city'			=> $city,
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

function checkUserLogin () {
	$CI =& get_instance();
	if ($CI->session->userdata('isAuthenticated') != 1 ) {
		$userObj = get_cookie('userObj');
		if ($userObj) {
			$userObj = unserialize($userObj);
			$CI->session->set_userdata($userObj );
		}
	} else {
		
	}
	/*
	global $LANDING_PAGE;
	
	$CI =& get_instance();
	if ($CI->session->userdata('isAuthenticated') != 1 ) {
		redirect($LANDING_PAGE);
	}
	*/
}

function generateRandomString ($length = 16) {

	// start with a blank password
	$password = "";
	// define possible characters
	$possible = "0123456789bcdfghjkmnpqrstvwxyz";    
	// set up a counter
	$i = 0; 
	// add random characters to $password until $length is reached
	while ($i < $length) { 
		// pick a random character from the possible ones
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		// we don't want this character if it's already in the password
		if (!strstr($password, $char)) { 
			$password .= $char;
			$i++;
		}
	}

	return $password;
}

/*
function createThumb($name,$filename,$new_w,$new_h) {
	$return = true; 
	$system=explode(".",$name);
	if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
	if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
	if (preg_match("/gif/",$system[1])){$src_img=imagecreatefromgif($name);}
	
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) 
	{
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
	}
	if ($old_x == $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/png/",$system[1])) {
		if (imagepng($dst_img,$filename) ) {
			$return = true;
		} else {
			$return = false;
		}
	} else if (preg_match("/gif/",$system[1])) {
		if (imagegif($dst_img,$filename) ) {
			$return = true;
		} else {
			$return = false;
		}
	} else {
		if (imagejpeg($dst_img,$filename) ) {
			$return = true;
		} else {
			$return = false;
		}
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img);
	
	return $return;
}
*/

// modified createThumb for square result. - Yoying Apri192011
function createThumb($source, $destination) {
	global $IMAGEMAGICK_PATH;
		
	$width = 200; 
    $height = 200;
    
    list($w,$h) = getimagesize($source);

    $thumbRatio = $width/$height;
    $inRatio = $w/$h;
    $isLandscape = $inRatio > $thumbRatio;

    $size = ($isLandscape ? '1000x'.$height : $width.'x1000');
    $xoff = ($isLandscape ? floor((($inRatio*$height)-$width)/2) : 0);
    $command = $IMAGEMAGICK_PATH." convert $source -resize $size -crop {$width}x{$height}+{$xoff}+0 ".
        "-colorspace RGB -strip -quality 90 $destination";

    system($command);
    
    return TRUE;
}

/*
function createThumb($source,$destination,$new_w,$new_h, $old_x, $old_y) {
	global $IMAGEMAGICK_PATH;
	$return = true; 
	
		if ($old_x > $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) 
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		$thumb_w = floor($thumb_w);
		$thumb_h = floor($thumb_h);
			
		$command = $IMAGEMAGICK_PATH . " $source    -resize ".$thumb_w."x".$thumb_h."!  $destination";
		//echo $command;
		system($command);
	
	return $return;
}
*/

function trimWhiteSpaces($string){
	$string = str_replace(" - ", " ", $string);
	$string = str_replace(".", "", $string);
	$string = str_replace(",", "", $string);
	$words = explode(" ", $string);
	$newString = ''; 
	if(sizeof($words) == 1 ){
		
		return $words[0];
		
	}else{
		foreach($words as $word){
			if($word != ''){
				$newString .= ' '.$word; 
			}
		}
		return trim($newString);
	}
}

function checkUserAgent($page = null, $id = null) {
	$_CI =& get_instance();
	$_CI->load->library('user_agent');
	
	if ($_CI->agent->is_mobile())
		$agent = 'mobile';
	elseif ($_CI->agent->is_robot())
		$agent = 'robot';
	elseif ($_CI->agent->is_browser())
		$agent = 'browser';
	else
		$agent = 'Unidentified User Agent';

	if( $agent == 'mobile' ) 
	{
		
		if ($page == null && $id == null)
		{
			redirect('/mobile');
		}
		else 
		{				
			redirect('/mobile/'.$page.'s/'.$id);		
		}
	}
}

function getUserAgent() {
	$_CI =& get_instance();
	$_CI->load->library('user_agent');

	if ($_CI->agent->is_mobile())
		$agent = $_CI->agent->mobile();
	elseif ($_CI->agent->is_robot())
		$agent = $_CI->agent->robot();
	elseif ($_CI->agent->is_browser())
		$agent = $_CI->agent->browser().' '.$_CI->agent->version();
	else
		$agent = 'Unidentified User Agent';
	
	return $agent;
}

function getUserGroupsArray() {
	global $USER_GROUP;
	
	return $USER_GROUP;
}

function getDefaultPortletPosition($page) {
	global $PORTLET;
	
	return $PORTLET[$page];
}

?>