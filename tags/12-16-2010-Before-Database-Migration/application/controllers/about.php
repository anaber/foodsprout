<?php

class About extends Controller {

    function __construct() {
        parent::Controller();
		checkUserLogin();
    }

    // The default goes to the about page
    function index() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_index');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/about',
        );

		// Data to send to the views
		$data['BREADCRUMB'] = array(
							'About' => '/about',
							'Food Sprout Mission' => '',
						);

        $this->load->view('/templates/left_center_template', $data);
    }

    // Contact information
    function contact() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_contact');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/contact',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'About' => '/about',
							'Contacting Food Sprout' => '',
						);
        
        $this->load->view('/templates/left_center_template', $data);
    }

	// Team information
    function team() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_team');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/team',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'About' => '/about',
							'Food Sprout Team' => '',
						);
        
        $this->load->view('/templates/left_center_template', $data);
    }

    // Information for business owners
    function business() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_business');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/business',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'About' => '/about',
							'Information for Restaurant &amp; Businesses' => '',
						);
        
        $this->load->view('/templates/left_center_template', $data);
    }

    // Feedback page to gather feedback from users
    function feedback() {
        
    }

	// The terms and conditions
    function terms() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_terms');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/terms',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'About' => '/about',
							'Terms & Conditions' => '',
						);
						
        $this->load->view('/templates/left_center_template', $data);
    }

	// The privacy policy
    function privacy() {
		// SEO
		$this->load->model('SeoModel');
		$seo = $this->SeoModel->getSeoDetailsFromPage('about_privacy');
		$data['SEO'] = $seo;
	
        // List of views to be included
        $data['LEFT'] = array(
            'navigation' => 'about/left_nav',
        );

        $data['CENTER'] = array(
            'content' => 'about/privacy',
        );

        // Data to send to the views
        $data['BREADCRUMB'] = array(
							'About' => '/about',
							'Food Sprout\'s Privacy Policy' => '',
						);
        
        $this->load->view('/templates/left_center_template', $data);
    }

    // The first page that loads on the beta
    function privatebeta($userData = null) {
        $data = array();

        $this->load->model('SeoModel');
        $seo = $this->SeoModel->getSeoDetailsFromPage('index');
        $data['SEO'] = $seo;
        if($userData)
        {
            $data['USER_DATA'] = $userData;
        }

        // List of views to be included
        //$data['CENTER'] = array(
        //    'list' => 'beta/beta1',
        //);

        $this->load->view('beta/beta1', $data);
    }

    // The second page for the beta test, AB test this page with Google Site Optimizer vs the page above (if we have time)
    function beta() {
        $data = array();

        $this->load->model('SeoModel');
        $seo = $this->SeoModel->getSeoDetailsFromPage('index');
        $data['SEO'] = $seo;

        // List of views to be included
        $data['CENTER'] = array(
            'list' => 'beta/beta2',
        );

        $this->load->view('templates/center_template_beta', $data);
    }

    // Create and add a new user to the database
    function create_user_no_ajax() {
        $GLOBALS = array();
        $this->load->library('form_validation');


        /* CI's validation engine creating issues, may be we are not using this correctly
         * We may use this section to validate see if password mathes or not.
         */
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        //$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required');

        $new_user_insert_data = array(
            'first_name' => $this->input->post('firstname'),
            'email' => $this->input->post('email'),
            'zipcode' => $this->input->post('zipcode'),
            'password' => md5($this->input->post('password')),
            'register_ipaddress' => $this->input->ip_address(), //$_SERVER['REMOTE_ADDR'], //Replaced by Nutan/Thakur
            'isActive' => 1
        );

        
        if ($this->input->post('password') != $this->input->post('password2')) {
            $new_user_insert_data['error'] = 'The passwords are not same.';
            $this->privatebeta($new_user_insert_data);
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $new_user_insert_data['error'] = 'The input data is not valid.';
            $this->privatebeta($new_user_insert_data);
            return;
        }

        $this->load->model('UserModel');
        $create_user = $this->UserModel->createUserNoAjax($new_user_insert_data);
        if ($create_user == true) {
            // Send the user to the dashboard
            // no need to send them from here. jquery will take care
            // $this->dashboard();
            // Now send them a welcome email
            $this->load->library('email');

            $this->email->from('contact@foodsprout.com', 'Food Sprout');
            $this->email->to($this->input->post('email'));

            $this->email->subject('Welcome to Food Sprout, ' . $this->input->post('firstname'));
            $this->email->message('Welcome ' . $this->input->post('firstname') . ",\r\n \r\nThank you for joining Food Sprout and taking an interest in learning more about where our food comes from and what is in it.  We hope you will also join us in sharing what information you have so that we may all benefit. \r\n \r\n Food Sprout Team");

            $this->email->send();

            //call home page after successful login
            $this->home();
            return;
        }

        //$this->load->view('/user/create_account');
        if (isset($GLOBALS['error']) && !empty($GLOBALS['error'])) {
            $new_user_insert_data['error'] = $GLOBALS['error'];
            $this->privatebeta($new_user_insert_data);
            return;
        }

        $new_user_insert_data['error'] = 'Error while creating user.';
        $this->privatebeta($new_user_insert_data);
        return;
    }

    //call home page
    function home() {
        $data = array();

        $this->load->model('SeoModel');
        $seo = $this->SeoModel->getSeoDetailsFromPage('index');
        $data['SEO'] = $seo;

        // List of views to be included
        $data['CENTER'] = array(
            'list' => 'home',
        );

        $this->load->view('templates/center_template', $data);
    }

	//send an email
    function sendMail() {
	
		if($this->input->post('sendemail') == FALSE)
		{
			redirect('about/contact');
		}
		else
		{
	
			// Validate the information before sending to model
			$this->load->library('form_validation');
		
			// field name, error message, validation rules
			$this->form_validation->set_rules('username', 'Name', 'trim|required');
			$this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email');
			if($this->form_validation->run() == FALSE)
			{
				$this->contact();
			}
			else
			{
				$this->load->library('email');
				
				$from = 'noreply@foodsprout.com';

				$this->email->from($this->input->post('useremail'));
				$this->email->reply_to($this->input->post('useremail'), $this->input->post('username'));
				$this->email->to('contact@foodsprout.com');

				$this->email->subject('Food Sprout Contact Form');
				$this->email->message($this->input->post('message'));

				$this->email->send();
				
				//echo $this->email->print_debugger();
	
        		$data = array();

        		// List of views to be included
        		$data['LEFT'] = array(
            		'navigation' => 'about/left_nav',
        		);

        		$data['CENTER'] = array(
            		'content' => 'about/contact',
        		);

        		// Data to send to the views
        		$data['BREADCRUMB'] = array(
							'Food Sprout' => '/',
							'Contacting Food Sprout' => '/about/contact',
						);
        
        		$this->load->view('/templates/left_center_template', $data);
			}
		}
    }
	

}
?>