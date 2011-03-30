<?php

class Fish extends Controller {
	
	function __construct()
	{
		global $ADMIN_LANDING_PAGE;
		parent::Controller();
		if ($this->session->userdata('isAuthenticated') != 1 || $this->session->userdata('userGroup') != 'admin' )
		{
			redirect($ADMIN_LANDING_PAGE);
		}
	}
	
	function index()
	{
		$this->list_fish();
	}
	
	// List all the fish in the database
	function list_fish()
	{
		$data = array();
		$fishes = array();
		
		$this->load->model('FishModel');
		$fishes = $this->FishModel->list_fish();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/fish',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Fishes";
		$data['data']['center']['list']['FISHES'] = $fishes;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function add()
	{
		$data = array();
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/fish_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Add Fish";
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_add() {
		
		$this->load->model('FishModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FishModel->addFish() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
	}
	
	function update($id)
	{
		$data = array();
		
		$this->load->model('FishModel');
		$fish = $this->FishModel->getFishFromId($id);
		
		// List of views to be included
		$data['CENTER'] = array(
				'list' => 'admincp/forms/fish_form',
			);
		
		// Data to be passed to the views
		$data['data']['center']['list']['VIEW_HEADER'] = "Update Fish";
		$data['data']['center']['list']['FISH'] = $fish;
		
		$this->load->view('admincp/templates/center_template', $data);
	}
	
	function save_update() {
		
		$this->load->model('FishModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->FishModel->updateFish() ) {
			echo "yes";
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
		
	}
}

/* End of file fish.php */

?>