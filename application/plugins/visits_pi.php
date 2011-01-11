<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visits {

	private $minimLogTime = "- 1 hour";

	private $visitorsTable = 'visits';

	private $CI;

	function __construct() {

		$this->CI = & get_instance();

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

		//check minim log time
		if($this->minimLogTime() == true){

			//insert records to database
			$this->CI->db->insert('visits', $data);
				
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
	function minimLogTime(){

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
