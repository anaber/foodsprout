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
		
		$cityId = $this->input->get('city');
		$lotteryId = $this->input->get('id');
		
		$this->load->model('LotteryModel', '', TRUE);
		
		if ($lotteryId) {
			$lottery = $this->LotteryModel->getLotteryFromId($lotteryId);
			$cityId = $lottery->cityId;
		}
		
		$cities = $this->LotteryModel->getApplicableCitiesForLottery();
		
		$lotteries = $this->LotteryModel->getLotteries($cities, $cityId);
		
		//print_r_pre($lotteries);
		
		$data['CENTER'] = array(
            'content' => 'tab/info',
        );
		// Data to send to the views
		
		$data['data']['center']['content']['LOTTRIES'] = $lotteries;
		$data['data']['center']['content']['FACEBOOK'] = $this->facebook;
		$data['data']['center']['content']['CITIES'] = $cities;
		
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