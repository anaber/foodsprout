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
		
		
		//email
		if($this->input->post('login_email') == "Email"){
			$data['ERROR'] = 'empty_email';
			$params[] = 'Please enter email address.';
			$data['flashdata'] = $params;
			$this->load->view('login', $data);
		}else{
			
			$authenticated = $this->LoginModel->validateUser();
                      
			if ($authenticated ==  false) {
				$data = array();
				
				$params[] = 'Login incorect! Please check user and password!';
				$data['flashdata'] = $params;
				
				$validation_error  = FALSE;
 
				if($this->session->userdata('accessBlocked') == 'yes') {
					$data['ERROR'] = 'blocked';
					$params[] = 'Access blocked!';
					$data['flashdata'] = $params;
				}else {                                          
					$data['ERROR'] = 'login_failed';
				}
				
				$this->load->view('login', $data);
			} else {
				
				$this->_CreateVanillaCookie();

				if ($return) {
					redirect($return);
				} else {
					if($this->input->get('frm') <> "")
						redirect($this->input->get('frm'));
					else
						redirect('/');
				}
			}
		}
	}
	
	// Used by Vanilla For Log In
	function auth() {
		$this->output->set_header("Content-Type: text/plain");
		printf('UniqueID=1'."\n");
		printf('Name=name'."\n");
		printf('Email=email@email.com'."\n");
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

		$this->_DeleteVanillaCookie();
		
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
		$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required|numeric');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[30]|required');
		
		
		
		//validate default value
		$validation_error = FALSE;
		$params = array();
				
		//full name
		if($this->input->post('firstname') == "Full Name"){
			   
			$params[] = 'Please fill the "Full Name" field!';
			$data['flashdata'] = $params;
			$validation_error = TRUE;
			
		}
		//email
		if($this->input->post('email') == "Email"){
			   
			$params[] = 'Please fill the "Email" field!';
			$data['flashdata'] = $params;
			$validation_error = TRUE;
			
		}
		
		//password
		if($this->input->post('password') == "Password"){
			   
			$params[] = 'Please fill the "Password" field!';
			$data['flashdata'] = $params;
			$validation_error = TRUE;
			
		}
		
		//password
		if($this->input->post('zipcode') == "Zip Code"){
			   
			$params[] = 'Please fill the "Zip Code" field!';
			$data['flashdata'] = $params;
			$validation_error = TRUE;
			
		}

		if($this->form_validation->run() == FALSE or $validation_error == TRUE){

			$data['CENTER'] = array(
					'list' => 'login',
			);				
			$data['FIRST_NAME'] = $this->input->post('firstname');
			$data['EMAIL'] = $this->input->post('email');
			$data['PASSWORD'] = '';
			$data['ZIPCODE'] = $this->input->post('zipcode');
			
			if ( isset ($GLOBALS['error']) && $GLOBALS['error']) {
				$data['ERROR'] = $GLOBALS['error'];
			} else {
				$params[] = 'Registration failed';
				$data['flashdata'] = $params;
				$data['ERROR'] = 'registration_failed';
			}
			
			$this->load->view('login', $data);
				
		}else{

			$this->load->model('UserModel');
			$create_user = $this->UserModel->createUser();

			if($create_user == true) {
					
				$this->load->library('email');

				$this->email->from('contact@foodsprout.com', 'Food Sprout');
				$this->email->to($this->input->post('email'));

				$this->email->subject('Welcome to Food Sprout, '.$this->input->post('firstname'));
				$this->email->message('Welcome '.$this->input->post('firstname').",\r\n \r\nThank you for joining Food Sprout and taking an interest in learning more about where our food comes from and what is in it.  We hope you will also join us in sharing what information you have so that we may all benefit. \r\n \r\n Food Sprout Team");

				$this->email->send();

				session_start();
				
				$params[] = 'Registration Success!';
				$data['flashdata'] = $params;
				$_SESSION['ERROR'] = 'registration_success';
				
				//echo $this->email->print_debugger();

				$this->_CreateVanillaCookie();

				if($this->input->get('frm') <> "")
					redirect($this->input->get('frm'));
				else
					redirect('/');
					
			} else {

				$data['CENTER'] = array(
					'list' => 'login',
				);
					
				$data['ERROR'] = $this->UserModel->get_error('create_user');

				$data['FIRST_NAME'] = $this->input->post('firstname');
				$data['EMAIL'] = $this->input->post('email');
				$data['PASSWORD'] = '';
				$data['ZIPCODE'] = $this->input->post('zipcode');

				$this->load->view('login', $data);
					
			}

		}

	}
	
	private function _CreateVanillaCookie() {
		$baseUrl = base_url();
		$url = parse_url ($baseUrl);
		$civ = base64_encode($this->session->userdata('userId'))."|".base64_encode($this->session->userdata('firstName'))."|".base64_encode($this->session->userdata('email'));
		$cookie = array(
						   'name'   => 'ci_v',
						   'value'  => $civ,
						   'expire' => time() + 3600,
						   'domain' => $url['host'],
						   'path'   => '/'
					   );

		set_cookie($cookie);	
	}
	
	// DELETE ALL COOKIES USED BY VANILLA
	private function _DeleteVanillaCookie() {
		$baseUrl = base_url();
		$url = parse_url ($baseUrl);
		
		$vanilla_cookies = array('ci_v', 'Vanilla', 'Vanilla-Volatile', 'VanillaProxy');
		
		foreach($vanilla_cookies as $cookies){
			$cookie = array(
							   'name'   => $cookies,
							   'value'  => '',
							   'expire' => time() - 3600,
							   'domain' => ".".$url['host'],
							   'path'   => '/'
						   );
			set_cookie($cookie);
		}
	}
	
	function forgotpassword(){
			
		// List of views to be included
		$data['CENTER'] = array(
				'form' => 'user/forgotpassword',
		);

		$this->load->view('templates/center_template', $data);
		
	}
	
	function resetnow(){
		
		
		if($this->input->post('email_reset') != ''){
			
			$this->load->model('UserModel');
			if($this->UserModel->resetpassword($this->input->post('email_reset')) == TRUE){
				
					$this->load->library('email');
	
					$this->email->from('contact@foodsprout.com', 'Food Sprout');
					$this->email->to($this->input->post('email_reset'));
	
					$this->email->subject('New password for Food Sprout');
					$this->email->message('New password for you account is: '.$this->UserModel->get_error('password').",\r\n \r\nThank you. \r\n \r\n Food Sprout Team");
	
					$this->email->send();

					// List of views to be included
					$data['CENTER'] = array(
							'form' => 'user/forgotpassword',
					);
					
					$data['error'] =   'New password has been sent to: '.$this->input->post('email_reset');
					
					$this->load->view('templates/center_template', $data);
					
			}else{
				
				// List of views to be included
				$data['CENTER'] = array(
						'form' => 'user/forgotpassword',
				);
				
				$data['error'] =   $this->UserModel->get_error('error');
		
				$this->load->view('templates/center_template', $data);
				
			}
			
		}else{
			// List of views to be included
				$data['CENTER'] = array(
						'form' => 'user/forgotpassword',
				);
				
				$data['error'] =   'Please fill the email field';
		
				$this->load->view('templates/center_template', $data);
			
		}
	
	}
}



?>