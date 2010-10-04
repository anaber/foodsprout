<?php
set_time_limit(0);

	error_reporting(E_ALL ^ E_WARNING);
	
$defines_file = '../includes/properties.php';
if (file_exists($defines_file))
{
	require_once($defines_file);
} 

$twitter = new Twitter();

$twitter->index();




class Twitter {
	
	function __construct() {
		
	}
	
	function index() {
		$this->getTwitterData(1, 30000);
	}
	
	function getTwitterData() {
		global $UPLOAD_FOLDER;
		
		$url = "http://twitter.com/statuses/user_timeline/124974783.rss";
		
		$ch = curl_init ();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POST, 0); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_VERBOSE, 0);
		$data = curl_exec ($ch);
		curl_close($ch);
		 
		if ( trim($data) ) {
			$file = $UPLOAD_FOLDER . "/twitter.rss";
			
			$fh = fopen($file, 'w');
			fwrite($fh, $data);
			fclose($fh);
		} else {
			return false;
		}
	}
}


?>
