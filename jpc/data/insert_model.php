<?php
/*****************************************************
This Model is  for inserting the data from Database.
******************************************************/
require_once('database_model.php');

class insert_model extends database_model{	

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
		
	public function insertReviewer($pv_first_name,$pv_last_name,$pv_state,$pv_city){
		$db = $this->db_connect();
		
		$sql="INSERT INTO ".$this->reviewer."(FirstName,LastName,City,State) VALUES ('".$pv_first_name."', '".$pv_last_name."', '".$pv_city."', '".$pv_state."')  ";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}
	public function insertReview($LastReviewerID,$pv_service_rating,$pv_recommend_rating,$pv_total_exp_rating,$pvReviewSummary,$pvReviewReview,$pvBranchSelector){
		$db = $this->db_connect();
		
		$sql="INSERT INTO ".$this->review."
		(ReviewerID,Service,WillRecommend,TotalExperience,ReviewSummary,Review,Branch) VALUES 
		('".$LastReviewerID."','".$pv_service_rating."','".$pv_recommend_rating."','".$pv_total_exp_rating."','".$pvReviewSummary."','".$pvReviewReview."','".$pvBranchSelector."')  ";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}
	public function insertFeedback($qid,$answer,$LastReviewerID){
		$db = $this->db_connect();
		
		$sql="INSERT INTO ".$this->feedback."
		(QuestionID,ReviewerID,Answer) VALUES 
		('".$qid."','".$LastReviewerID."','".$answer."')  ";
		$result = $db->query($sql);

		if($result){
			return true;
		}else{
			die("MYSQL Error : ".mysqli_error($db));
		}	
	}
	
}