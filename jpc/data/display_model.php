<?php
/*****************************************************
This Model is  for pulling out the data from Database.
******************************************************/

require_once('database_model.php');


class display_model extends database_model{	

	protected $feedback; 
	protected $fields; 
	protected $intake;   
	protected $submitter;

	
	public function __construct(){
		global $wpdb;

		$this->feedback = "`".$wpdb->prefix."intake_feedback`";
		$this->fields = "`".$wpdb->prefix."fields`";
		$this->intake  = "`".$wpdb->prefix."intake`";
		$this->submitter = "`".$wpdb->prefix."submitter`";

	}

	
	
}