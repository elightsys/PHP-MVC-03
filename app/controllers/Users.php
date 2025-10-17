<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class Users extends Controller {

	private static $userModel;
	
	public function __construct() {
		if (!isLoggedIn()) {		
			header('location:' . __ROOT_URL__ );
			exit();
		}
		//$this->userModel = $this->model('AdminModel');	
		self::$userModel = $this->model('AdminModel');		
    }
	
		public function AjaxUserEdit() {		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){			
			$request = json_decode(json_encode($_POST));			
			$verifyToken = md5('unique_salt' . $request->timestamp);			
			//if (Controller::csrf($request->token)) {
			if ($verifyToken == $request->token) {		
				$id = intval($request->id);
				$response = self::$userModel->requestUser($id);				
				if ($response){
					$response->access_pages = explode(', ', $response->access_pages);
					
					exit(json_encode($response));
				} else {
					$data[0] = 'SQL error.';
				}				
			} else {
				$data[0] = 'Token error.';
			}
			exit(json_encode($data));			
		}
		header('location:' . __ROOT_URL__ );
		exit();
	}
	
	public function AjaxUserDel() {
		
		if($_SERVER['REQUEST_METHOD'] === 'POST'){			
			//$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);		
			//$request = json_decode(json_encode($_POST));

			$request = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    		$request = json_decode(json_encode($request));
			
			$verifyToken = md5('unique_salt' . $request->timestamp);
			
			if ($verifyToken != $request->token){				
				$data[0] = 'Token error.';
			}
			
			if ($request->id && empty($data[0])){
				$id = intval($request->id);
				if (self::$userModel->delUserModel($id)) {
					$data[1] = 'A törlés sikeres.';
				} else {
					$data[0] = 'SQL error...';
				}
			} elseif (empty($data[0])) {

				$data[0] = 'Something went wrong...'; 
			}
			
			exit (json_encode($data));
			
		}
		//echo 'Someting went wrong...';
		header('location:' . __ROOT_URL__ );
		exit();
	}
	
	public function AjaxUserAddForm() {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			//$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);		
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$request = json_decode(json_encode($_POST));
			
			$verifyToken = md5( __UNIQID__ . $request->timestamp);
			//$verifyToken = md5('unique_salt' . $request->timestamp);
			//$err = false;		

			//$data = $this->inputModel->inputValidate($request, $this->ajaxModel);
						
			$request->fullname = ucwords(strtolower(trim($request->fullname)), " ");
			$request->newEmail = trim(strtolower($request->newEmail));
			$request->newPassword = trim($request->newPassword);
			$request->confirmPassword = trim($request->confirmPassword);		
			//$request->invcode = trim($request->invcode);
			$request->token = trim($request->token);
			
			$dt['err'] = false;
			
			// FULL NAME
			if (empty($request->fullname)) {
				$data['fullnameError'] = 'Please enter your full name';
				$dt['err'] = true;
			}  elseif (!HandleForm::validate($request->fullname, 'text')) {
				$data['fullnameError'] = 'Full name can only text';
				$dt['err'] = true;
			}

			// EMAIL
			if (empty($request->newEmail)) {
				$data['newEmailError'] = 'Please enter login e-mail address';
				$dt['err'] = true;
			} elseif (!HandleForm::validate($request->newEmail, 'email')) {
				$data['newEmailError'] = 'Please enter the correct e-mail format';
				$dt['err'] = true;
			} elseif ($request->newEmail != $request->origyEmail){
				if (self::$userModel->findUserByEmail($request->newEmail)) {
					$data['newEmailError'] = 'E-mail is already taken'; 
					$dt['err'] = true;
				}
			}
								
			// Validate password on length, numeric values,
			if(!empty($request->newPassword)){
				if(strlen($request->newPassword) < 6){
					$data['newPasswordError'] = 'Password must be at least 8 characters';
					$dt['err'] = true;
				} elseif (!HandleForm::validate($request->newPassword, 'userpass')) {
					$data['newPasswordError'] = 'Password must be have at least one numeric, alphabets and special characther value';
					$dt['err'] = true;
				}
			}

			//Validate confirm password
			if (!empty($request->newPassword) && empty($request->confirmPassword)) {
				$data['confirmPasswordError'] = 'Please enter password';
				$dt['err'] = true;					
			} else {
				if ($request->newPassword != $request->confirmPassword) {
					$data['confirmPasswordError'] = 'Passwords do not match, please try again';
					$dt['err'] = true;
				}
			}
			
			if ($verifyToken != $request->token) {
				$data['tokenError'] = 'Token error.';
				$dt['err'] = true;
			}
			/*
			if (!Controller::csrf($request->token)) {
				$data['tokenError'] = 'Token error.';
				$data['messageError'] = true;
			}*/
			
			if (!$dt['err']) {
				$lastId = self::$userModel->addUser($request);
				//echo '<pre>',print_r($this->ajaxModel->addUser($request)),'</pre>';		
				//exit();
				//$lastId = 1;
				if ($lastId) {
					
					$data[1] = (($request->id)?'modify':'create');//'A felvétel sikers';
					exit (json_encode($data));
				} else {
					$data[0] = 'SQL error';
				}
			}
			//unset($data['messageError']);
			exit (json_encode($data));			
		} 
		header('location:' . __ROOT_URL__ );
		exit();	
	}

}