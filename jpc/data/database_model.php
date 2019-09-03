<?php
/******************************************************************
This Model is the parent model class that returns database object
*******************************************************************/

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-config.php');


class database_model{	

	public function db_connect(){
		$localhost	= DB_HOST;
		$user		= DB_USER;
		$pw			= DB_PASSWORD;
		$database	= DB_NAME;
		$db = new mysqli($localhost, $user, $pw, $database);
		if($db){
			return $db;
		}else{
			 die("Connection failed: " . $conn->connect_error);
		}
	}
	public function create_tables(){
	
		global $wpdb;
		
		$db = $this->db_connect();

		/* 
		intake_status
			2 = Pending
			1 = Approved
			0 = Deleted
		*/
		$sql1="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."intake` (
				 `intake_id` int(11) NOT NULL AUTO_INCREMENT,
				 `name_to` varchar(100) NOT NULL AUTO_INCREMENT,
				 `name_from` varchar(11) NOT NULL AUTO_INCREMENT,
				 `intake_message` text NOT NULL AUTO_INCREMENT,
				 `date_answered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				 `intake_status` int(11) NOT NULL DEFAULT '2',
				 `is_viewed` int(11) NOT NULL DEFAULT '0',
				 PRIMARY KEY (`intake_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";

			
		$rs1 = $db->query($sql1);

		if($rs1 ){
			return true;
		}else{
			return false;
		}

	}
}