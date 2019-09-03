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
		$sql1="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."intake_feedback` (
				 `intake_feedback_id` int(11) NOT NULL AUTO_INCREMENT,
				 `submitter_id` int(11) NOT NULL,
				 `field_id` int(11) NOT NULL,
				 `answer` varchar(250) NOT NULL,
				 `date_answered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				 `is_viewed` int(11) NOT NULL DEFAULT '0',
				 PRIMARY KEY (`FeedbackID`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";
				
		$sql2="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."fields`(
			 `field_id` int(10) NOT NULL AUTO_INCREMENT,
			 `field_name` varchar(250) NOT NULL,
			 `status` int(1) NOT NULL DEFAULT '1',
			 PRIMARY KEY (`QuestionID`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";
			
		$sql3="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."intake` (
			 `intake_id` int(10) NOT NULL AUTO_INCREMENT,
			 `submitter_id` int(10) NOT NULL,
			 `status` int(1) NOT NULL DEFAULT '2',
			 `date_submit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 `is_viewed` int(11) NOT NULL DEFAULT '0',
			 PRIMARY KEY (`ReviewID`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";

		$sql4="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."submitter` (
			 `submitter_id` int(11) NOT NULL AUTO_INCREMENT,
			 `fname` varchar(50) NOT NULL,
			 `lname` varchar(50) NOT NULL,
			 `city` varchar(50) NOT NULL,
			 `state` varchar(50) NOT NULL,
			 PRIMARY KEY (`submitter_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1";
			
		$sql5="INSERT INTO `".$wpdb->prefix."fields` (`field_id`, `field_name`, `status`) VALUES
				(1, 'To', 1),
				(2, 'From', 1),
				(3, 'Message', 1);
		";
			
		$rs1 = $db->query($sql1);
		$rs2 = $db->query($sql2);
		$rs3 = $db->query($sql3);
		$rs4 = $db->query($sql4); 
		$rs5 = $db->query($sql5);

		if($rs1 && $rs2 && $rs3 && $rs4 && $rs5 && $rs6 ){
			return true;
		}else{
			return false;
		}

	}
}