<?php

class Tab extends Controller {

    function __construct() {
        global $FB_APP_ID, $FB_SECRET_KEY;
        parent::Controller();
		checkUserLogin();
		
		$this->load->plugin('facebook');
		
		$this->facebook = new Facebook(array(
  							'appId'  => $FB_APP_ID,
  							'secret' => $FB_SECRET_KEY,
  							'cookie' => true,
						));
		
		
		//$user = $this->facebook->require_login();
    }

    // The default goes to the about page
    function index() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('tab_index');
		$data['SEO'] = $seo;

		$this->load->model('LotteryModel', '', TRUE);
		$lotteries = $this->LotteryModel->getLotteries();
		
		//print_r_pre($lotteries);
		
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
        $data['data']['center']['content']['FACEBOOK'] = $this->facebook;
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