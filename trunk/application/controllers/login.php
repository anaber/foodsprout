<?php

class Login extends Controller {
	
	function __construct() {
		parent::Controller();
		checkUserLogin();
	}
	
	function index() {
		
		if ($this->session->userdata('isAuthenticated') == 1 ) {
			redirect('/home');
		} else {
			$data = array();

	        $this->load->model('SeoModel');
	        $seo = $this->SeoModel->getSeoDetailsFromPage('index');
	        $data['SEO'] = $seo;
	        
	        $this->load->view('login', $data);
		}
	}
	
	// Check the user's data is valid
	function validate() {
		
		$return = $this->input->post('return');
		
		$this->load->model('LoginModel', '', TRUE);
		$authenticated = $this->LoginModel->validateUser();
		
		if ($authenticated ==  false) {
			$data = array();
			if($this->session->userdata('accessBlocked') == 'yes') {
				$data['ERROR'] = 'blocked';
			} else {
				$data['ERROR'] = 'login_failed';
			}
			
			$this->load->view('login', $data);
		} else {
			
			if ($return) {
				redirect($return);
			} else {
				redirect('/');
			}
		}
		
	}
	
	// End a users session	
	function signout() {
		$baseUrl = base_url();
		$url = parse_url ($baseUrl);
		$cookie = array(
               'name'   => 'userObj',
               'value'  => '',
               'expire' => time()-60*60*24*30*365,
               'domain' => $url['host'],
               'path'   => '/',
               'prefix' => '',
           );
		set_cookie($cookie);
		$this->session->sess_destroy();
		redirect('/');
	}
	
	// Create and add a new user to the database
	function create_user() {
		$GLOBALS = array();
		
		// Validate the information before sending to model
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('firstname', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		
		if($this->form_validation->run() == FALSE)
		{
			$data = array();
			$data['CENTER'] = array(
					'list' => 'login',
			);
			
			if ( isset ($GLOBALS['error']) && $GLOBALS['error']) {
				$data['ERROR'] = $GLOBALS['error'];
			} else {
				$data['ERROR'] = 'registration_failed';
			}
			
			$data['FIRST_NAME'] = $this->input->post('firstname'); 
			$data['EMAIL'] = $this->input->post('email');
			$data['PASSWORD'] = '';
			$data['ZIPCODE'] = $this->input->post('zipcode');
			
			$this->load->view('login', $data);
			exit;
		}
		
		$this->load->model('UserModel');
		$create_user = $this->UserModel->createUser();
		
		if($create_user == true) {
			
			$this->load->library('email');

			$this->email->from('contact@foodsprout.com', 'Food Sprout');
			$this->email->to($this->input->post('email'));

			$this->email->subject('Welcome to Food Sprout, '.$this->input->post('firstname'));
			$this->email->message('Welcome '.$this->input->post('firstname').",\r\n \r\nThank you for joining Food Sprout and taking an interest in learning more about where our food comes from and what is in it.  We hope you will also join us in sharing what information you have so that we may all benefit. \r\n \r\n Food Sprout Team");

			$this->email->send();
			
			
			//echo $this->email->print_debugger();
			
			redirect('/');
			
		} else {
			
			$data = array();
			$data['CENTER'] = array(
					'list' => 'login',
			);
			
			if ( isset ($GLOBALS['error']) && $GLOBALS['error']) {
				$data['ERROR'] = $GLOBALS['error'];
			} else {
				$data['ERROR'] = 'registration_failed';
			}
			
			$data['FIRST_NAME'] = $this->input->post('firstname'); 
			$data['EMAIL'] = $this->input->post('email');
			$data['PASSWORD'] = '';
			$data['ZIPCODE'] = $this->input->post('zipcode');
			
			$this->load->view('login', $data);
			
		}
		
	}
}



?>