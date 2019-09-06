<?php
/*****************************************************
This Model is  for pulling out the data from Database.
******************************************************/

require_once('database_model.php');


class display_model extends database_model{	

	protected $intake;   

	public function __construct(){
		global $wpdb;
		$this->intake  = "`".$wpdb->prefix."intake`";
	}

	/* 
	intake_status
		2 = Pending
		1 = Approved
		0 = Deleted
	*/
	public function show_all_intake_by_status($status){
		$db = $this->db_connect();
		$sql="SELECT 
				intake_id, name_to, name_from, intake_message, date_answered
			  FROM " . $this->intake . " 
			  WHERE intake_status = '$status'";
		$result = $db->query($sql);

		if($result){
			return $result;
		}else{
			return mysqli_error($db);
		}		
	}

	public function get_intake_by_id($id){
		$db = $this->db_connect();
		$sql="SELECT 
				intake_id, name_to, name_from, intake_message, date_answered
			  FROM " . $this->intake . " 
			  WHERE intake_id = '$id'";
		$result = $db->query($sql);
		if($result){
			return $result;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
		
	}

	public function get_notif(){
		$db = $this->db_connect();
		$sql = "SELECT COUNT(intake_id) as notif FROM ".$this->intake." WHERE is_viewed = 0 and intake_status = 2";
		$result = $db->query($sql);
		if($result){
			$row = $result->fetch_assoc();
			return $row['notif'];
		}else{ 
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}	
}