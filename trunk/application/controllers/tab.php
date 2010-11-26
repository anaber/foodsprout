<?php

class Tab extends Controller {

    function __construct() {
        parent::Controller();
		checkUserLogin();
    }

    // The default goes to the about page
    function index() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('tab_index');
		$data['SEO'] = $seo;

		$this->load->model('LotteryModel', '', TRUE);
		$lotteries = $this->LotteryModel->getLotteries();
		
		$data['CENTER'] = array(
            'content' => 'tab/info',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'Tab\'s on Us' => '/tab',
						);

		$data['data']['center']['content']['LOTTRIES'] = $lotteries;

        $this->load->view('/templates/center_template', $data);
    }

    // Lottery Detail
    function detail($id) {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('tab_detail');
		$data['SEO'] = $seo;

		$this->load->model('LotteryModel', '', TRUE);
		$lottery = $this->LotteryModel->getLotteryFromId($id);

        $data['CENTER'] = array(
            'content' => 'tab/detail',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'Tab\'s on Us' => '/tab',
							'This Week\'s Restaurant' => '',
						);
        $data['data']['center']['content']['LOTTERY'] = $lottery;
        $this->load->view('/templates/center_template', $data);
    }

	function enroll() {
		$this->load->model('LotteryModel', '', TRUE);
		
		$GLOBALS = array();
		if ( $this->LotteryModel->enroll() ) {
			echo 'yes';
		} else {
			if (isset($GLOBALS['error']) && !empty($GLOBALS['error']) ) {
				echo $GLOBALS['error'];
			} else {
				echo 'no';
			}
		}
    }
		

}
?>