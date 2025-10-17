<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class Admin extends Controller {
	
	protected static $userModel;
    
	public function __construct() {		
        //$this->userModel = $this->model('AdminModel');	
		self::$userModel = $this->model('AdminModel');	
    }
	
	public function index() {
		
		$data = [
			'title' => 'Login page',
				
            'email' => '',
            'password' => '',
			
            'emailError' => '',
			'fullnameError' => '',
			'newEmailError' => '',
			'newPasswordError' => '',
            'passwordError' => '',
			'confirmPasswordError' => '',
			'err' => ''
        ];
		$data['page'] = 'signin';
		
		if (isLoggedIn()) {
			$data['title'] = 'Dashboard';
			
			$this->view('index', $data);
			exit();
		
		} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			if (isset($_POST['btn_signin'])) {
			
				$data['email'] = trim($_POST['email']);
				$data['password'] = trim($_POST['password']);
				//$data['page'] = 'signin';
				
				//Validate username
				if (empty($data['email'])) {
					$data['email'] = 'Please enter login e-mail';
					$data['passwordemail'] = 'Please enter login e-mail';
				}

				//Validate password
				if (empty($data['password'])) {
					$data['passwordError'] = 'Please enter password';
				}

				//Check if all errors are empty
				if (empty($data['emailError']) && empty($data['passwordError'])) {
					
					//$loggedInUser = $this->userModel->login($data['email'], $data['password']);
					$userModel = self::$userModel;
					$loggedInUser = $userModel->login($data['email'], $data['password']);
					

					if ($loggedInUser) {				
						
						//$this->userModel->createUserSession($loggedInUser);
						$userModel->createUserSession($loggedInUser);
							
						header('location:' . __ROOT_URL__ );
										
					} else {
						
						//$this->userModel->userLog($data['email'], 0);
						
						$data['passwordError'] = 'Login failed! Invalid email-id or password! Please try again.';
						
						//$this->view('admin/index', $data);
						//exit();
					}
				}
			} else {				
				
				$data['page'] = 'signup';
				
				//$data['fullname'] = ucfirst(strtolower(trim($_POST['fullname'])));
				$data['fullname'] = ucwords(strtolower(trim($_POST['fullname'])), " ");				
				$data['newEmail'] = trim(strtolower($_POST['newEmail']));
				$data['newPassword'] = trim($_POST['newPassword']);
				$data['confirmPassword'] = trim($_POST['confirmPassword']);		
				$data['invcode'] = trim($_POST['invcode']);
				$data['token'] = trim($_POST['token']);
				
				
				$data['err'] = false;
				// FULL NAME
				if (empty($data['fullname'])) {
					$data['fullnameError'] = 'Please enter your full name';
					$data['err'] = true;
				}  elseif (!HandleForm::validate($data['fullname'], 'text')) {
					$data['fullnameError'] = 'Full name can only text';
					$data['err'] = true;
				}

				// EMAIL
				if (empty($data['newEmail'])) {
					$data['newEmailError'] = 'Please enter login e-mail address';
					$data['err'] = true;
				} elseif (!HandleForm::validate($data['newEmail'], 'email')) {
					$data['newEmailError'] = 'Please enter the correct e-mail format';
					$data['err'] = true;
				} elseif ($this->userModel->findUserByEmail($data['newEmail'])) {
					//Check if email exists. 			
					$data['newEmailError'] = ' E-mail is already taken'; //$data['newEmail'].
					//$data['newEmail'] = '';
					$data['err'] = true;
				}
				
				// invcode
				/*
				if (empty($data['invcode'])) {
					$data['invcodeError'] = 'Please enter registration key';
					$data['err'] = true;
				}  elseif (!HandleForm::validate($data['invcode'], 'userpass')) {
			       $data['invcodeError'] = 'Only contain letters and numbers';
				   $data['err'] = true;
				} elseif ( $data['invcode'] != __INV_CODE__ ) {
					$data['invcodeError'] = 'Regkey is incorrect, please try again';
					$data['err'] = true;
				}
				*/
				
				// Validate password on length, numeric values,
				if(empty($data['newPassword'])){
					$data['newPasswordError'] = 'Please enter password';
					$data['err'] = true;
				} elseif(strlen($data['newPassword']) < 6){
					$data['newPasswordError'] = 'Password must be at least 8 characters';
					$data['err'] = true;
				} elseif (!HandleForm::validate($data['newPassword'], 'userpass')) {
					$data['newPasswordError'] = 'Password must be have at least one numeric, alphabets and special characther value';
					$data['err'] = true;
				}

				//Validate confirm password
				if (empty($data['confirmPassword'])) {
					$data['confirmPasswordError'] = 'Please enter password';
					$data['err'] = true;					
				} else {
					if ($data['newPassword'] != $data['confirmPassword']) {
						$data['confirmPasswordError'] = 'Passwords do not match, please try again';
						$data['err'] = true;
					}
				}				
				
				// reCAPTCHA validation
				/*if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {				
					if( !$this->userModel->reCaptcha($_POST['g-recaptcha-response']) ){
						$data['captchaError'] = 'Robot verification failed, please try again';
					}				
				} else{ 
					$data['captchaError'] = 'Plese check on the reCAPTCHA box';       
				}*/
				
				//$this->view('admin/index', $data);
				//exit();
				//echo '<pre>',print_r($data),'</pre>';
				//exit('OK');
				
				// END OF FORM Data
				if (empty($data['newEmailError']) && empty($data['fullnameError']) && empty($data['newPasswordError']) && empty($data['confirmPasswordError']) ) { // && empty($data['invcodeError']) && Controller::csrf($data['token'])
				// && empty($data['captchaError'])
				
					// Hash password
					$data['password'] = password_hash($data['newPassword'], PASSWORD_DEFAULT);
					
					$lastId = $this->userModel->registery($data);
					
					if (!$lastId) {
						$data['msgError'] = 'Something went wrong... Please try again!'; 
					} else {
						$data['page'] = 'signin';
					}
				}
				
			//$this->view('admin/index', $data);
			//exit();
			}
        }
		
		$this->view('admin/index', $data);
		exit();
	}
	
	public function logout() {
		unset($_SESSION['user_id']);
        unset($_SESSION['firstname']);
		unset($_SESSION['lastname']);
        unset($_SESSION['email']);
		unset($_SESSION['uniqueKey']);
		unset($_SESSION['role']);
		unset($_SESSION['access_pages']);
		unset($_SESSION['session']);
		session_destroy();
		header('location:' . __ROOT_URL__ );
    }
	
}