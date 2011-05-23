<?php

class Lottery extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('access') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/lottery',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Lotteries";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Create the form page to add a manufacture to the database, does not actually add the data, only builds the form
	function add() {
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/lottery_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['form']['VIEW_HEADER'] = "Add Lottery";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	// Update a record using an id
	function update($id) {
		
		$data = array();
		
		$this->load->model('LotteryModel');
		$lottery = $this->LotteryModel->getLotteryFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'admincp/forms/lottery_form',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $id;
		
		$data['data']['center']['form']['VIEW_HEADER'] = "Update Lottery";
		$data['data']['center']['form']['LOTTERY'] = $lottery;
		
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	// Pass the form data to the model to be inserted into the database
	function save_add() {
		
		$this->load->model('LotteryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->LotteryModel->addLottery() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function save_update() {
		
		$this->load->model('LotteryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->LotteryModel->updateLottery() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function ajaxSearchLotteries() {
		$this->load->model('LotteryModel', '', TRUE);
		$lotteries = $this->LotteryModel->getLotteriesJsonAdmin();
		echo json_encode($lotteries);
	}
	
	function add_prize($id)
	{
		$data = array();
		
		$this->load->model('LotteryModel');
		$lottery = $this->LotteryModel->getLotteryFromId($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/prize_form',
			);
		$this->load->model('PrizeModel');
		$prizes = $this->PrizeModel->getPrizesForLottery($id);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($lottery->lotteryName, '', 'prize', 'add');
		$data['data']['center']['list']['LOTTERY'] = $lottery;
		$data['data']['center']['list']['PRIZES'] = $prizes;
		
		$data['BREADCRUMB'] = array(
				'Lottery' => '/admincp/lottery',
				$lottery->lotteryName => '/admincp/lottery/update/' . $lottery->lotteryId,
				'Add Prize' => '/admincp/lottery/add_prize/' . $lottery->lotteryId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function prize_save_add() {
		
		$this->load->model('PrizeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PrizeModel->addLotteryPrize() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
	
	function prize_save_update() {
		
		$this->load->model('PrizeModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->PrizeModel->updateLotteryPrize() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function update_prize($id)
	{
		$data = array();
		
		$this->load->model('PrizeModel');
		$prize = $this->PrizeModel->getPrizeFromId($id);
		
		$this->load->model('LotteryModel');
		$lottery = $this->LotteryModel->getLotteryFromId($prize->lotteryId);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/prize_form',
			);
		
		$prizes = $this->PrizeModel->getPrizesForLottery($prize->lotteryId);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $prize->lotteryId;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($lottery->lotteryName, $id, 'prize', 'update');
		$data['data']['center']['list']['LOTTERY'] = $lottery;
		$data['data']['center']['list']['PRIZE'] = $prize;
		$data['data']['center']['list']['PRIZES'] = $prizes;
		
		$data['BREADCRUMB'] = array(
				'Lottery' => '/admincp/lottery',
				$lottery->lotteryName => '/admincp/lottery/update/' . $prize->lotteryPrizeId,
				'Prize #' . $prize->lotteryPrizeId => '/admincp/lottery/update_prize/' . $prize->lotteryPrizeId,
			);
			
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function photo_save_add() {
		$this->load->model('PhotoModel', '', TRUE);
		$GLOBALS = array();
		
		$return = $this->PhotoModel->addLotteryPhoto();
		if ( $return ) {
			echo json_encode($return);
			//echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}	
	}
	
	function photo_save_update() {
		echo "Deepak here";
		/*
		$this->load->model('PhotoModel', '', TRUE);
		$GLOBALS = array();
		
		$return = $this->PhotoModel->updateLotteryPhoto();
		if ( $return ) {
			echo json_encode($return);
			//echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		*/
	}
	
	function entries($id) 
	{
		$data = array();
		
		$this->load->model('LotteryModel');
		$lottery = $this->LotteryModel->getLotteryFromId($id);
		$entries = $this->LotteryModel->getEntriesForLotteryById($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/lottery/lottery_entries',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $id;
		
		$data['data']['center']['list']['VIEW_HEADER'] = prepareHeading($lottery->lotteryName, '', 'entries', '');
		$data['data']['center']['list']['LOTTERY'] = $lottery;
		$data['data']['center']['list']['ENTRIES'] = $entries;
		
		$data['BREADCRUMB'] = array(
				'Lottery' => '/admincp/lottery',
				$lottery->lotteryName => '/admincp/lottery/update/' . $lottery->lotteryId,
				'Entries' => '/admincp/lottery/entries/' . $lottery->lotteryId,
			);
			
					
		$this->load->view('admincp/templates/left_center_template', $data);
	}
	
	function draw($id)
	{
		
		$this->load->model('LotteryModel');
		
		if ($this->input->post('pick'))
		{
			$this->LotteryModel->pickLotteryPrizeWinner();
		}
		$data = array();
			
		$lottery = $this->LotteryModel->getLotteryFromId($id);
		$prizes = $this->LotteryModel->getPrizesByLotteryId($id);	
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/lottery/lottery_draw',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $id;
				
		$data['data']['center']['list']['LOTTERY'] = $lottery;
		$data['data']['center']['list']['PRIZES'] = $prizes;
				
		$data['BREADCRUMB'] = array(
				'Lottery' => '/admincp/lottery',
				$lottery->lotteryName => '/admincp/lottery/update/' . $lottery->lotteryId,
				'Draw' => '/admincp/lottery/draw/' . $lottery->lotteryId
			);
			
					
		$this->load->view('admincp/templates/left_center_template', $data);		
		
	}
	
	function winners($id)
	{
		$data = array();
		
		$this->load->model('LotteryModel');
		$lottery = $this->LotteryModel->getLotteryFromId($id);
		$winners = $this->LotteryModel->getWinnersForLotteryById($id);
		
		// List of views to be included
		$data['LEFT'] = array(
				'navigation' => 'admincp/includes/left/nav_lottery',
			);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/lottery/lottery_winners',
			);
		
		// Data to be passed to the views
		$data['data']['left']['navigation']['VIEW_HEADER'] = "Options";
		$data['data']['left']['navigation']['LOTTERY_ID'] = $id;
				
		$data['data']['center']['list']['LOTTERY'] = $lottery;
		$data['data']['center']['list']['WINNERS'] = $winners;
		
		$data['BREADCRUMB'] = array(
				'Lottery' => '/admincp/lottery',
				$lottery->lotteryName => '/admincp/lottery/update/' . $lottery->lotteryId,
				'Winners' => '/admincp/lottery/winners/' . $lottery->lotteryId
			);
			
					
		$this->load->view('admincp/templates/left_center_template', $data);		
	}
	
	
	
}

/* End of file company.php */

?>