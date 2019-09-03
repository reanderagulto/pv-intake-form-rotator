<?php
/*****************************************************
This Model is  for editing the data from Database.
******************************************************/
require_once('database_model.php');

class edit_model extends database_model{	

	protected $feedback; 
	protected $question; 
	protected $review;   
	protected $reviewer;

	public function __construct(){
		global $wpdb;

		$this->feedback = "`".$wpdb->prefix."private_feedback`";
		$this->question = "`".$wpdb->prefix."question`";
		$this->review  = "`".$wpdb->prefix."review`";
		$this->reviewer = "`".$wpdb->prefix."reviewer`";

	}
	
	public function updateReview($ReviewID,$service,$recommend,$experience,$summary,$review){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->review." 
				SET Service = '".$service."',
				WillRecommend = '".$recommend."',
				TotalExperience = '".$experience."',
				ReviewSummary = '".$summary."',
				Review='".$review."' 
				WHERE ReviewID = '".$ReviewID."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}
	public function isViewed(){
		$db = $this->db_connect();
		
		$sql = "UPDATE ".$this->review." 
				SET isViewed = 1
				WHERE Status = 2";
		$result = $db->query($sql);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}		
	}
	public function view_feedback(){
		$db = $this->db_connect();
		
		$sql = "UPDATE ".$this->feedback." SET isViewed = 1";
		
		$result = $db->query($sql);
		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}		
	}
	public function updateReviewer($ReviewerID,$fname,$lname,$city,$state){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->reviewer." 
				SET FirstName = '".$lname."',
				FirstName = '".$fname."',
				LastName = '".$lname."',
				City = '".$city."',
				State='".$state."' 
				WHERE ReviewerID = '".$ReviewerID."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}
	public function deactivate($id){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->review." 
				SET Status = '0'
				WHERE ReviewID = '".$id."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}	
	public function activate($id){	
		$db = $this->db_connect();
		
		$sql="  UPDATE ".$this->review." 
				SET Status = '1'
				WHERE ReviewID = '".$id."' 
			";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}	
	//Delete
	public function deleteFeedbackViaID($id){
		$db = $this->db_connect();
		
		$sql="DELETE FROM ".$this->feedback." WHERE ReviewerID='".$id."'";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}
	}
}