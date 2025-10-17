<?php
require_once ('helpers/session_helper.php');
require_once ('config/config.php');
require_once ('controllers/AuthController.php');

use app\Controllers\AuthController;

$controller = new AuthController();

$csrf_token = $controller->generateCsrfToken();

//PHPMailer
//require 'third_party/phpmailer/Exception.php';
//require 'third_party/phpmailer/PHPMailer.php';
//require 'third_party/phpmailer/SMTP.php';
//require_once ('third_party/tcpdf/tcpdf.php');

spl_autoload_register(
	function ($className){
		
		if (file_exists('../app/controllers/' . $className . '.php')){
			require_once ('../app/controllers/' . $className . '.php');			
		} else if (file_exists('../app/models/' . $className . '.php')){
			require_once ('../app/models/' . $className . '.php');	
		} else if (file_exists('../app/libraries/' . $className . '.php')){
			require_once ('../app/libraries/' . $className . '.php');			
		}
});

new Bootstrap();