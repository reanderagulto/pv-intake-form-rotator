<?php
if($_GET){
	require_once("insert_model.php");
	require_once("edit_model.php");
	
	$add =  new insert_model();
	$edit = new edit_model();
	
	extract($_GET);
	//Deactivate 
	if($mode == "deactivate" ){
		$result = $edit->deactivate($id);
		if($result){
			header('location:'.$redirect.'&msg=success');
		}else{
			die("Error : MYSQL Query Database Error (get.php)");
		}
	}
	//Activate
	if($mode == "activate" ){
		$result = $edit->activate($id);
		if($result){
			header('location:'.$redirect.'&msg=success');
		}else{
			die("Error : MYSQL Query Database Error (get.php)");
		}
	}	
	if($mode == "delete_feedback" ){
		$delete = $edit->deleteFeedbackViaID($id);
		if($delete){
			header('location:'.$redirect.'&msg=success');
		}else{
			die("Error : MYSQL Query Database Error (get.php)");
		}
	}
}else{
	die("Error 403 : Forbidden");
}