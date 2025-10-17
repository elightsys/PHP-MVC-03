<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class AdminModel {
    
	private $db;
    
	public function __construct() {		
        $this->db = new Database;		
    }

	public function login($email, $password) {
		
		$currentDate = date('U');
        
		// SELECT LOGIN USER
		$this->db->query('SELECT * FROM users WHERE email = :email LIMIT 1');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
		
        if ($row) {

			$hashedPassword = $row->password;
			$active = $row->active;	

			//$hashedPassword = password_hash('zuiZ74a77*222', PASSWORD_DEFAULT);
			
			//exit($hashedPassword .' !!!! ' . $password .' -> '. password_verify('zuiZ74a77*222', $hashedPassword));
			
			if ($active && password_verify($password, $hashedPassword)) {
				
				// UPDATE LOGIN DATE
				$this->db->query('UPDATE users SET login_date = NOW() WHERE id = :id');
				$this->db->bind( ':id', $row->id );
				if ($this->db->execute()) {
					return $row;
				} return false;
				
			} else {				
				return false;
			}
		} else {
			return false;
		}
    }
	
	public function createUserSession($user) {
		session_regenerate_id();
        $_SESSION['user_id'] 		= $user->id;
        $_SESSION['fullname'] 		= $user->fullname;
        $_SESSION['email'] 			= $user->email;
		$_SESSION['uniqueKey'] 		= $user->unique_key;
		$_SESSION['role'] 			= $user->role;
		$_SESSION['access_pages']	= $user->access_pages;
		$_SESSION['session'] 		= session_id();
			
		//header('location:' . __ROOT_URL__ );
    }
	/*
	public function register($data) {
		
		$unique_key = bin2hex(random_bytes(8));		
	
		$this->db->query('INSERT INTO users (email, fullname, password, unique_key, create_date, modify_date) VALUES( :email, :firstname, :lastname, :password, :unique_key, NOW(), NOW())');

        $this->db->bind(':email', $data['email']);
		$this->db->bind(':fullname', $data['fullame']);
		//$this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':password', $data['password']);
		$this->db->bind(':unique_key', $unique_key);

        //Execute function
        if ($this->db->execute()) {            
			return $this->db->lastId();
			//return true;
        } else {
            return false;
        }
    }
	*/
	public function findUserByEmail($email) {

		$this->db->query('SELECT * FROM users WHERE email = :email');
		
        $this->db->bind(':email', $email);
		$this->db->execute();

        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function registery($data) {
		
		$unique_key = bin2hex(random_bytes(8));		
	
		$this->db->query('INSERT INTO users (email, fullname, password, unique_key, create_date, modify_date) VALUES( :email, :fullname, :password, :unique_key, NOW(), NOW())');

        $this->db->bind(':email', $data['newEmail']);
		$this->db->bind(':fullname', $data['fullname']);
		//$this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':password', $data['password']);
		$this->db->bind(':unique_key', $unique_key);

        //Execute function
        if ($this->db->execute()) {            
			return $this->db->lastId();
			//return true;
        } else {
            return false;
        }
    }
	
	public function delUserModel($id) {		
		$this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);	        
		if($this->db->execute()) {
			return true;
		}
        return false;		
    }
	
	public function requestUser($id) {		
		$this->db->query('SELECT * FROM users WHERE id = :id LIMIT 1');		
		$this->db->bind(':id', $id);	
        $row = $this->db->single();		
		if ($row) {			
			return $row;
		}		
		return false;		
	}
	
	public function addUser($data) {		
		
		$unique_key = bin2hex(random_bytes(8));
		
		// Hash password
        $data->newPassword = (($data->newPassword)?password_hash($data->newPassword, PASSWORD_DEFAULT):'');
		$newpassDB = (($data->newPassword)?'password= :password,':'');
		/*
		$data->access_pages = ((isset($data->access_pages) && !empty($data->access_pages))?implode(', ', $data->access_pages):'');
		*/
		$data->access_pages = '';
		//exit($data->access_pages);
		//		
		$update = (($data->id) ? 'ON DUPLICATE KEY UPDATE email= :email, fullname= :fullname,  '.$newpassDB.' role= :role, active= :active, offline= :offline, attempt= :attempt, access_pages= :access_pages, modify_date= NOW()' : '');
		 
		
		$this->db->query('INSERT INTO users (email, fullname, password, unique_key, role, active, offline, attempt, access_pages, create_date, modify_date) VALUES( :email, :fullname, :password, :unique_key, :role, :active, :offline, :attempt, :access_pages, NOW(), NOW())'. $update ); // 
		
		$this->db->bind(':email', 			$data->newEmail);
		$this->db->bind(':fullname', 		$data->fullname);		
			
		$this->db->bind(':password', 		$data->newPassword);
		$this->db->bind(':unique_key', 		$unique_key);
		$this->db->bind(':role', 			isset($data->role)?intval($data->role):0);
		$this->db->bind(':active', 			isset($data->active)?intval($data->active):0);
		$this->db->bind(':offline', 		isset($data->offline)?intval($data->offline):0);
		$this->db->bind(':attempt', 		isset($data->attempt)?intval($data->attempt):0);
		$this->db->bind(':access_pages', 	$data->access_pages);
		
		//Execute function
		//return $this->db->execute2try();	
		if ($this->db->execute()) {            
			return $this->db->lastId();
			//return true;
        } else {
            return false;
        }		
	}
	

}