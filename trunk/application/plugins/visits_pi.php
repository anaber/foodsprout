<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visits {

	private $minimLogTime = "- 1 day";

	private $visitorsTable = 'visits';

	private $CI;

	function __construct() {

		$this->CI = & get_instance();

	}

	function addProducer($producerId){

		$data['visitedAddress'] = $this->visitedAddress();
		$data['visitorIp'] = $this->visitorIp();
		$data['producer_id'] = $producerId	;
		$data['visitDate'] = $this->visitDate();
		$data['visitorId'] = $this->visitorId();
		$data['visitorAgent'] = $this->visitorAgent();
		$data['visitorOS'] = $this->visitorOS();

		//load database
		$this->CI->load->database();

		//check if user is already in visitor table
		$visitorDetails =  $this->CI->db->query("select * from visitor where `user_id` = '".$this->visitorId()."' and `ip_address` = '".$this->visitorIp()."' order by visitor_id desc limit 1 ");
			
		//if visitor is not in table 
		if($visitorDetails->num_rows() == 0){
			//insert it to database
			$insertResults = $this->CI->db->insert('visitor', array(
				'ip_address' => $this->visitorIp(), 
				'user_id' => $this->visitorId(),
				'visitor_agent' => $this->visitorAgent(),
				'visitor_os' => $this->visitorOS()
			)); 
				
			$visitorPageId =  $this->CI->db->insert_id();
		
		}else{
			
			$visitorDetails = $visitorDetails->result_array();
			$visitorId = $visitorDetails[0]['visitor_id'];
			
		}
			
			
		//check if page is in visitor page table in last minim time
		$visitsTableResults = $this->CI->db->query("select * from visitor_page where `visitor_id` = '".$visitorId."' and `date` >= '".date('Y-m-d H:i:s', strtotime( $this->minimLogTime ,strtotime($this->visitDate())))."' and `producer_id` = '".$producerId."' order by visitor_page_id desc limit 1 "); 
		
		if($visitsTableResults->num_rows() > 0 ){
			
			$visitsTableResults = $visitsTableResults->result_array();
 		
			//update record
			$updateParams['count'] = $visitsTableResults[0]['count'] +  1; 
			$this->CI->db->where('visitor_page_id', $visitsTableResults[0]['visitor_page_id']);
			$this->CI->db->update('visitor_page', $updateParams); 
     
		}else{
			
			//insert record
			$insertParams['visitor_id'] = $visitorId;
			$insertParams['producer_id'] 	= $producerId;
			$insertParams['date']		= $this->visitDate(); 
			$insertParams['count']		= 1;
				
			$this->CI->db->insert('visitor_page', $insertParams); 
			
			
		}
		
	}
	

	function addVisit(){

		$data['visitedAddress'] = $this->visitedAddress();
		$data['visitorIp'] = $this->visitorIp();
		$data['visitDate'] = $this->visitDate();
		$data['visitorId'] = $this->visitorId();
		$data['visitorAgent'] = $this->visitorAgent();
		$data['visitorOS'] = $this->visitorOS();

		//load database
		$this->CI->load->database();

		//check if user is already in visitor table
		$visitorDetails =  $this->CI->db->query("select * from visitor where `user_id` = '".$this->visitorId()."' and `ip_address` = '".$this->visitorIp()."' order by visitor_id desc limit 1 ");
			
		//if visitor is not in table 
		if($visitorDetails->num_rows() == 0){
			//insert it to database
			$insertResults = $this->CI->db->insert('visitor', array(
				'ip_address' => $this->visitorIp(), 
				'user_id' => $this->visitorId(),
				'visitor_agent' => $this->visitorAgent(),
				'visitor_os' => $this->visitorOS()
			)); 
				
			$visitorPageId =  $this->CI->db->insert_id();
		
		}else{
			
			$visitorDetails = $visitorDetails->result_array();
			$visitorId = $visitorDetails[0]['visitor_id'];
			
		}
			
			
		//check if page is in visitor page table in last minim time
		$visitsTableResults = $this->CI->db->query("select * from visitor_page where `visitor_id` = '".$visitorId."' and `date` >= '".date('Y-m-d H:i:s', strtotime( $this->minimLogTime ,strtotime($this->visitDate())))."' and `page_url` = '".$this->visitedAddress()."' order by visitor_page_id desc limit 1 "); 
		
		if($visitsTableResults->num_rows() > 0 ){
			
			$visitsTableResults = $visitsTableResults->result_array();
 		
			//update record
			$updateParams['count'] = $visitsTableResults[0]['count'] +  1; 
			$this->CI->db->where('visitor_page_id', $visitsTableResults[0]['visitor_page_id']);
			$this->CI->db->update('visitor_page', $updateParams); 
     
		}else{
			
			//insert record
			$insertParams['visitor_id'] = $visitorId;
			$insertParams['page_url'] 	= $this->visitedAddress();
			$insertParams['date']		= $this->visitDate(); 
			$insertParams['count']		= 1;
				
			$this->CI->db->insert('visitor_page', $insertParams); 
			
			
		}
		
	}

	/*
	 * return an array with number of visits for an url splitted by year-month-day-hour
	 *
	 */
	function getVisitStats($url, $start_date, $end_date){

		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					day(visitDate) as day, 
					hour(visitDate)as hour, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate BETWEEN  '".$start_date."' AND '".$end_date."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate), 
						day(visitDate), 
						hour(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);
		if($result->num_rows > 0){
			 	
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	/*
	 * return true if last record is oldest that minim log time
	 */
	function checkMinimLogTime(){

		$query = "select * from ".$this->visitorsTable." where `visitedAddress` = '".$this->visitedAddress()."'
				 and `visitorIp` = '".$this->visitorIp()."' 
				 and `visitDate` > '".date('Y-m-d H:i:s', strtotime( $this->minimLogTime ,strtotime($this->visitDate())))."'"; 
		$results = $this->CI->db->query($query);

		if($results->num_rows() > 0){
				
			//if records are found in minim log time return false
			return false;
				
		}else{
				
			return true; 

	          
		}

	}

	function visitedAddress(){

		//$this->CI->load->library('url');
		return $this->CI->uri->uri_string();

	}

	function visitorIp(){

		return $this->CI->input->ip_address();

	}

	function visitDate(){

		return date("Y-m-d H:i:s", time());

	}

	function visitorId(){

		if($this->CI->session->userdata('userId') != ''){

			return $this->CI->session->userdata('userId');

		}else{

			return "anonymous";

		}

	}

	function visitorAgent(){
		//stuff that uses CI
		$CI = & get_instance();
		$CI->load->library('user_agent');
		if($CI->agent->is_robot())
		{
			return FALSE;
		}
		else
		{

			if ($CI->agent->is_browser())
			{
				$agent = $CI->agent->browser().' '.$CI->agent->version();
			}
			elseif ($CI->agent->is_mobile())
			{
				$agent = $CI->agent->mobile();
			}
			else
			{
				$agent = 'Unidentified User Agent';
			}


			return $agent;
		}
	}

	function visitorOS(){
		//stuff that uses CI
		$CI =& get_instance();
		$CI->load->library('user_agent');
			
		return $CI->agent->platform();

	}


	function dailyUnique($url, $start_date, $end_date){

		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					day(visitDate) as day, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate BETWEEN  '".$start_date."' AND '".$end_date."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate),  
						day(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);
		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function weeklyUnique($url, $start_date, $end_date){
		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate BETWEEN  '".$start_date."' AND '".$end_date."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);
		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function monthUnique($url, $start_date, $end_date){
		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate BETWEEN  '".$start_date."' AND '".$end_date."'	
					group by
						year(visitDate), 
						month(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);

		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function yearUnique($url, $start_date, $end_date){
		$query = "
				SELECT
					year(visitDate) as year
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate BETWEEN  '".$start_date."' AND '".$end_date."'	
					group by
						year(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);

		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function totalByDay($url, $date){
		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					day(visitDate) as day, 
					hour(visitDate)as hour, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  visitDate =  '".$date."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate), 
						day(visitDate), 
						hour(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);

		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function totalByWeek($url, $weekNumber){
		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					day(visitDate) as day, 
					hour(visitDate)as hour, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  week(visitDate) =  '".$weekNumber."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate), 
						day(visitDate), 
						hour(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);

		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function totalByMonth($url, $monthNumber){
		$query = "
				SELECT
					year(visitDate) as year, 
					month(visitDate) as month, 
					week(visitDate) as week, 
					day(visitDate) as day, 
					hour(visitDate)as hour, 
					count(visitedAddress) counter, 
					visitedAddress as address
					FROM `visits`
					where visitedAddress = '".$url."' and 
						  month(visitDate) =  '".$monthNumber."'	
					group by
						year(visitDate), 
						month(visitDate), 
						week(visitDate), 
						day(visitDate), 
						hour(visitDate), 
						visitedAddress
				";
		$result = $this->CI->db->query($query);

		if($result->num_rows > 0){
				
			return $result->result_array();
				
		}else{
				
			return array();
				
		}
	}

	function totalByYear($url, $year){
		$query = "
					SELECT
						year(visitDate) as year, 
						month(visitDate) as month, 
						week(visitDate) as week, 
						day(visitDate) as day, 
						hour(visitDate)as hour, 
						count(visitedAddress) counter, 
						visitedAddress as address
						FROM `visits`
						where visitedAddress = '".$url."' and 
							  year(visitDate) =  '".$year."'	
						group by
							year(visitDate), 
							month(visitDate), 
							week(visitDate), 
							day(visitDate), 
							hour(visitDate), 
							visitedAddress
					";
		$result = $this->CI->db->query($query);
			
		if($result->num_rows > 0){

				return $result->result_array();

		}else{

			return array();

		}
	}



}
?>
