<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class Controller {
	
	public function model($model) {
        //Require model file
        require_once '../app/models/' . $model . '.php';
        //Instantiate model
        return new $model();
	}

    public function view($view, $data = []) {
		
        if (file_exists(__ROOT_APP__ . '/views/' . $view . '.php')) {
			
            require_once __ROOT_APP__ . '/views/' . $view . '.php';
			
        } else {			
            die("Controller: View does not exists. (".__ROOT_APP__."/views/".$view.".php)");
        }
			
    }
	
	public static function csrf($token) {
        if ($_SESSION['token'] === $token) {
            if (time() <= $_SESSION['token-expire']) {
                return true;
            }
        }
        return false;
    }

}