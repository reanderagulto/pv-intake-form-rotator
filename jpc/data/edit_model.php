<?php
/*****************************************************
This Model is  for editing the data from Database.
******************************************************/
require_once('database_model.php');

class edit_model extends database_model{	

	protected $intake;   

	public function __construct(){
		global $wpdb;
		$this->intake  = "`".$wpdb->prefix."intake`";
	}
	
	public function is_viewed($id){
		$db = $this->db_connect();
		
		$sql = "UPDATE ".$this->intake." 
				SET is_viewed = 1
				WHERE intake_id = '$id'";
		$result = $db->query($sql);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}		
	}
	public function deactivate_intake($id){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->intake." 
				SET intake_status = '0'
				WHERE intake_id = '".$id."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}	
	public function approve_intake($id){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->intake." 
				SET Status = '1'
				WHERE intake_id = '".$id."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}	 
}