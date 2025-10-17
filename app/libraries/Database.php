<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

    class Database {
		
        private $dbHost = __DB_HOST__;
        private $dbUser = __DB_USER__;
        private $dbPass = __DB_PASS__;
        private $dbName = __DB_NAME__;

        private $statement;
        private $dbHandler;
        private $error;

        public function __construct() {
			//$tz = 'Europe/Budapest'; //Stockholm
			//$charset = 'utf8mb4';
						
            $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".__DB_CHARSET__ //.", time_zone = '".__TIME_ZONE__."'"
				//PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+02:00'"
            );
            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
				
				//SET GLOBAL time_zone = TIMEZONE;
				//SET time_zone = "+01:00";
				//SET @@session.time_zone = "+01:00";
				
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
				echo '<script>console.log("'.$this->error.'"); </script>'; 
				die ('Database Error. Please visit later.'); //$this->error
                
            }
        }

        //Allows us to write queries
        public function query($sql) {
            $this->statement = $this->dbHandler->prepare($sql);
        }

        //Bind values
        public function bind($parameter, $value, $type = null) {
            
			switch (is_null($type)) {
				
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            $this->statement->bindValue($parameter, $value, $type);
        }

        //Execute the prepared statement
        public function execute() {
			try {
				return $this->statement->execute();
			} catch (PDOException $e) {
				if ($e->errorInfo[1] == 1062) { // duplicate unique!!!
					exit($e); //return $e; //false;
				} else {
					exit($e); //return $e; //false;
				// an error other than duplicate entry occurred
				}
			}
        }
		
		public function execute2try() {
			try {
				$this->statement->execute();
				return array(true, 'Success');
			} catch (PDOException $e) {
				if ($e->errorInfo[1] == 1062) { // duplicate unique!!!
					return array(false, "SQL errorInfo 1062: {$e}"); //false;
				} else {
					return array(false, "SQL catch error: {$e}"); //false;
				// an error other than duplicate entry occurred
				}
			}
			
        }
		
		public function lastId() {
			//exit('OK: '. $this->dbHandler);
			//$this->statement->execute();
			return $this->dbHandler->lastInsertId();
		}

        //Return an array
        public function resultSet() {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC / FETCH_OBJ
        }
		
		public function resultFetch() {
            return $this->statement->fetch(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC / FETCH_OBJ
        }
		
		public function last_id(){
			//$this->execute();
			return $this->conn->lastInsertId();
		}
        //Return a specific row as an object
        public function single() {
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }

        //Get's the row count
        public function rowCount() {
			
            return $this->statement->rowCount();
        }
    }
