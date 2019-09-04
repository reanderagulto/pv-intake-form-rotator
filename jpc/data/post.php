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

if(isset($intake_submit)){
	$intake = $add->insert_intake($pv_to, $pv_from,$pv_message);

	//If Success 
	if($intake){
		header('location:'.$intake_redirect.'?msg=success');
	}
	else{
		header('location:'.$intake_redirect.'?msg='.$intake);
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