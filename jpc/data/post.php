<?php
/*************************************************************
This is for the main controller that processes the POST Values
*************************************************************/

require_once("insert_model.php");
require_once("edit_model.php");
require_once("display_model.php");

$add =  new insert_model();
$edit = new edit_model();
$get = new display_model();

extract($_POST);

if(isset($btnEdit)){
	$ret_review   = $edit->updateReview($ReviewID,$service,$recommend,$experience,$summary,$review);
	$reviewer = $edit->updateReviewer($ReviewerID,$fname,$lname,$city,$state);
	
	if($ret_review && $reviewer){
		header('location:'.$redirect.'&msg=success');
	}else{
		header('location:'.$redirect.'&msg=error');
	}
}
else if(isset($pv_submit)){
	$reviewer = $add->insertReviewer(stripslashes($pv_first_name),stripslashes($pv_last_name),stripslashes($pv_state),stripslashes($pv_city));
	$LastReviewerID = $get->getLastreviewerID();
	$review = $add->insertReview($LastReviewerID,$pv_service_rating,$pv_recommend_rating,$pv_total_exp_rating,stripslashes($pvReviewSummary),stripslashes($pvReviewReview),stripslashes($pvBranchSelector));
	
	$questions = $get->getAllQuestions();
	
	if($question!=null){
		while($row = $questions->fetch_assoc()){
			$answer = $_POST['question'][1][$row['QuestionID']];
			$qid    = $row['QuestionID'];
			if($answer!=null){
				$feedback = $add->insertFeedback($qid,$answer,$LastReviewerID);
			}
		}
	}
	//If Success 
	if($reviewer && $LastReviewerID && $review){
		header('location:'.$redirect.'?msg=success');
	}
}

/**
*
*No action callback
*
**/

else{
	die("Error 403 : Forbidden");
}