<?php
defined('__ROOT_URL__') OR exit('No direct script access allowed');

class SspModel {
	
	private $sql_set = array(
		'user' => __DB_USER__, //$db_username,
		'pass' => __DB_PASS__, //$db_password,
		'db'   => __DB_NAME__, //$db_name,
		'host' => __DB_HOST__ //$db_host
	);
	
	private $table = 'datatables_demo';
	private $primaryKey = 'id';
    
	public function __construct() {		
        //$this->SSP = new Ssp;
		new Ssp;		
    }
	
	public function sspDataTable($post){
		$columns = array(			
			array( 'db' => 'a.first_name', 'dt' => 0, 'field' => 'first_name' ),
			array( 'db' => 'a.last_name', 'dt' => 1, 'field' => 'last_name' ),
			array( 'db' => 'a.position', 'dt' => 2, 'field' => 'position' ),
			array( 'db' => 'a.email', 'dt' => 3, 'field' => 'email' ),
			array( 'db' => 'a.office', 'dt' => 4, 'field' => 'office' ),
			array( 'db' => 'a.start_date', 'dt' => 5, 'field' => 'start_date' ),
			array( 'db' => 'a.age', 'dt' => 6, 'field' => 'age' ),
			array( 'db' => 'a.salary', 'dt' => 7, 'field' => 'salary' ),
			array( 'db' => 'a.seq', 'dt' => 8, 'field' => 'seq' ),
			array( 'db' => 'a.extn', 'dt' => 9, 'field' => 'extn' )
		);
		$joinQuery = "FROM ".$this->table." AS a";
		
		$extraWhere = null;//"`u`.`salary` >= 90000";
		$groupBy = null; //"`u`.`office`";
		$having = null;//"`u`.`salary` >= 140000";
		
		return json_encode(
			SSP::simple( $post, $this->sql_set, $this->table, $this->primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
		);		
	}
	
	public function sspUserDT($post){
		$table = 'users';
		$table2 = 'mvc_user_roles';
		$columns = array(			
			array( 'db' => 'a.fullname', 'dt' => 0, 'field' => 'fullname' ),
			array( 'db' => 'a.active', 'dt' => 1, 'field' => 'active', 'formatter' => function($d, $row) {			
				return '<div style="text-align:center;">'.(($d)?'<i class="fas fa-toggle-on fa-lg" style="color: green"></i>':'<i class="fas fa-toggle-off fa-lg" style="color: red"></i>').'</div>';
			}),
			array( 'db' => 'b.role_name', 'dt' => 2, 'field' => 'role_name' ),
			//array( 'db' => 'a.group', 'dt' => 3, 'field' => 'group' ),
			array( 'db' => 'a.offline', 'dt' => 3, 'field' => 'offline' ),
			array( 'db' => 'a.email', 'dt' => 4, 'field' => 'email' ),
			array( 'db' => 'a.login_date', 'dt' => 5, 'field' => 'login_date' ),
			array( 'db' => 'a.create_date', 'dt' => 6, 'field' => 'create_date' ),
			array( 'db' => 'a.id', 'dt' => 7, 'field' => 'id', 'formatter' => 	function($d, $row) {	
				return '
					<div style="white-space: nowrap; text-align: center;">
						<button type="button" class="btn btn-danger btn_del_user btn-sm" data-user-id="'.$d.'" title="Delete row"><i class="fas fa-trash fa-sm"></i></button>
						<button type="button" class="btn btn-warning btn_edit_user btn-sm" data-toggle="modal" data-target="#userModalCenter" data-user-id="'.$d.'" title="Edit row"><i class="fas fa-edit fa-sm"></i></button>
					</div>';					
			})
		);
		$joinQuery = "FROM ".$table." AS a JOIN ".$table2." AS b ON (b.role_id = a.role)";		
		
		$extraWhere = null;//"`u`.`salary` >= 90000";
		$groupBy = null; //"`u`.`office`";
		$having = null;//"`u`.`salary` >= 140000";
		
		return json_encode(
			SSP::simple( $post, $this->sql_set, $table, $this->primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
		);		
	}
	
}