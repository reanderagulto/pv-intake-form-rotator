<?php
/*****************************************************
This Model is  for inserting the data from Database.
******************************************************/
require_once('database_model.php');

class insert_model extends database_model{	

	protected $intake;   

	public function __construct(){
		global $wpdb;
		$this->intake  = "`".$wpdb->prefix."intake`";
	}

	public function insert_intake($to, $from, $message){
		$db = $this->db_connect();
		
		$sql="INSERT INTO ".$this->intake."
			(name_to,name_from,intake_message) 
			VALUES 
			('".$to."','".$from."','".$message."')  ";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}
	
}