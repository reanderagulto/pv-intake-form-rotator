<?php
if($_GET){
	extract($_GET);
	require_once($dir.'../data/display_model.php'); 
	$get = new display_model();
	

	if($mode == 'feedback' ){
		$feedback = $get->getFeedbackViaID($id);
		echo '<table>';
		$ctr = 1;
		while($row = $feedback->fetch_assoc()){
			echo '
				<tr>
					<td>'.$ctr.'. '.$row['Question'].'</td>
					<td>'.$row['Answer'].'</td>
				</tr>
			';
			$ctr++;
		}
		echo '</table>';
	}
	else{
		die('Error 403 : ajax-load.php requires params');
	}
}
//No action callback
else{
	die('Error 403 : Forbidden');
} 