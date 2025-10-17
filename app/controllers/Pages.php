<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class Pages extends Controller {

	protected static $sspModel;
	
	public function __construct() {
		if (!isLoggedIn()) {		
			header('location:' . __ROOT_URL__ );
			exit();
		}
		//$this->sspModel = $this->model('SspModel');
		self::$sspModel = $this->model('SspModel');	
		
    }
	
	public function index() {		
		header('location:' . __ROOT_URL__ . '/error404' );         
    }
	
	public function About(){		
		$data = [
			'title' => 'About page',
			'page' => 'about'
        ];
		
		$this->view('pages/about', $data);        
    }
	
	public function Datatables(){		
		$data = [
			'title' => 'Datatable page',
			'page' => 'datatable'
        ];
		
		$this->view('pages/datatable', $data);        
    }
	
	public function Users(){		
		$data = [
			'title' => 'Users Datatable',
			'page' => 'userstd'
        ];
		$this->view('pages/users', $data);        
    }
	
	public function SspDataTable(){
		//$verifyToken = md5('unique_salt' . intval($_POST['timestamp']));
		//if(isset($_POST['draw']) && $_POST['token'] == $verifyToken){
		if (isset($_POST['draw'])){
			
			exit ( self::$sspModel->sspDataTable($_POST) );			
		
		} else {
			//$data[0] = 'Tokken error.'; 
			//exit (json_encode($data));		
			header('location:' . __ROOT_URL__ .'/error404' );
			exit();		
		}
	}
	
	public function SspUsersDT(){
		//$verifyToken = md5('unique_salt' . intval($_POST['timestamp']));
		//if(isset($_POST['draw']) && $_POST['token'] == $verifyToken){
		if (isset($_POST['draw'])){
			
			exit ( self::$sspModel->sspUserDT($_POST) );			
		
		} else {
			//$data[0] = 'Tokken error.'; 
			//exit (json_encode($data));		
			header('location:' . __ROOT_URL__ .'/error404' );
			exit();		
		}
	}
	
}