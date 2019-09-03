<?php
/**
 * Create admin Page to list unsubscribed emails.
**/

// Hook for adding admin menus
	add_action('admin_menu', 'create_main_page');
// action function for above hook
 
/**
* Adds a new top-level page to the administration menu.
**/
function get($strings){
	return plugins_url('/data/get.php'.$strings.'',__FILE__ );
}
function primeview_review_form(){
	return require_once('templates/main-form.php');
}
add_shortcode( 'primeview-review-form' , 'primeview_review_form' );

function view_primeview_review(){
	return require_once('templates/view-review.php');
}
add_shortcode( 'view-primeview-review' , 'view_primeview_review' );


function create_main_page(){
	

	$ratings = '<span class="update-plugins count-'.getNotif('ratings').'"><span class="plugin-count">'.getNotif('ratings').'</span></span>';
	$feedback = '<span class="update-plugins count-'.getNotif('feedback').'"><span class="plugin-count">'.getNotif('feedback').'</span></span>';
	
	add_menu_page( 
		'Pv Ratings', 							 // Page Title
		'PV Ratings'.$ratings.'',				// Navbar Title
		'manage_options',      					 // Permission 
		'primeview-rating',      					 // Page ID
		'main_page',           			 	  	 // Function call
		'dashicons-star-filled',   					 // Favicon
		2                				 	// Order
	);
	
	add_submenu_page( 
		'primeview-rating',      			 		 // Parent Page ID
		'Private Feedback',     		 		 // Page Title
		'Private Feedback'.$feedback.'',				// Navbar Title
		'manage_options', 						 // Permission 	
		'private-feedback', 							 // Submenu Page ID
		'pv_feedback' 								 // Function  call	 
	); 
	add_submenu_page( 
		'primeview-rating',      			 		 // Parent Page ID
		'PV Ratings Settings',     		 				 // Page Title
		'Settings', 						 // Navbar Title
		'manage_options', 						 // Permission 	
		'pv-settings', 							 // Submenu Page ID
		'pv_rating_settings' 								 // Function  call	 
	); 	
}
function getNotif($mode){
	require_once('data/display_model.php');
	$get = new display_model();
	
	$ratings = $get->getNotif(2); //2 = Pending;
	$feedback = $get->getNotifFeedback();
	
	$count = "";
	if($mode == "ratings"){
		$count = $ratings;
	}
	else if($mode == "feedback"){
		$count = $feedback;
	}
	return $count;
}
//Page Proper
function main_page(){
	require_once('data/display_model.php');
	require_once('data/edit_model.php');
	
	$get  = new display_model();
	$edit = new edit_model();
	
	$table = $get->get_rating_table();
	$pending = $get->get_pending_table();
	$trash = $get->get_trash_rating_table(); 
	
	//Update isViewed
	$isViewed =  $edit->isViewed();
 ?>
	
	<h2 class="pv-h2">Primeview Ratings</h2>
	<table style="margin-left: 22px;margin-bottom: 17px;font-weight: bold;">
		<tbody>
		<tr>
			<td>Form Shortcode : </td>
			<td>[primeview-review-form]</td>
		</tr>
		<tr>
			<td>View Reviews Shortcode : </td>
			<td>[view-primeview-review]</td>
		</tr>
		</tbody>
	</table>

	<ul class="tabs">
	 <li class="active" rel="pending-review-tab"><a href="#pending-review-tab">Pending Reviews</a></li>
	  <li  rel="review-tab"><a href="#review-tab">Active Reviews</a></li>
	  <li rel="trash-review-tab"><a href="#trash-review-tab">Trash</a></li>
	 
	</ul>
		<div class="tab_container">
			<div id="pending-review-tab" class="tab_content">
				<table class="data-table wp-list-table widefat fixed striped posts dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Branch</th>
							<th>Name</th>
							<th>Date</th>
							<th>Ratings</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$ctr = 1;
						while($row = $pending->fetch_assoc()){
							$rating = (($row['Service'] + $row['WillRecommend'] + $row['TotalExperience'])/ 3);
							$status = "";
							$color = "";
							if($row['Status'] == 1){
								$status = "Enabled";
								$color = "green";	
							}else if($row['Status'] == 2){
								$status = "Pending";
								$color = "orange";	
							}else{
								$status = "Disabled";
								$color = "red";
							}
							echo '
								<tr>
									<td>'.$ctr.'</td>
									<td>'.$row['Branch'].'</td>
									<td>
										<strong>'.$row['FirstName'].' '.$row['LastName'].'</strong>
										<div class="row-actions">
											<span class="view">
												<a href="#TB_inline?width=600&height=650&inlineId=rating-view" class="thickbox view-review "   data-branch="'.$row['Branch'].'" data-reviewid="'.$row['ReviewID'].'" data-reviewerid="'.$row['ReviewerID'].'" data-state="'.$row['State'].'" data-city="'.$row['City'].'" data-review="'.$row['Review'].'" data-summary="'.$row['ReviewSummary'].'" data-experience="'.$row['TotalExperience'].'" data-recommend="'.$row['WillRecommend'].'" data-service="'.$row['Service'].'" data-fname="'.$row['FirstName'].'" data-lname="'.$row['LastName'].'" class="view-review"  >View</a> |  
											</span>
											<span class="restore">
												<a href="'.get("?mode=activate&id=".$row['ReviewID']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="submitdelete">Enable</a> |
											</span>
											<span class="trash">
												<a href="'.get("?mode=deactivate&id=".$row['ReviewID']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="submitdelete">Trash</a>
											</span>
										</div>
									</td> 
									<td>'.date('M d, Y',strtotime($row['DateSubmitted'])).'</td>
									<td>'.$rating.'</td>
									<td style="font-weight:bold; color:'.$color.'" >'.$status.'</td>	
								</tr>					
							';
							$ctr++;
						}
					?>

					</tbody>
				</table>	
			</div>		
			<div id="review-tab" class="tab_content">
				<table class="data-table wp-list-table widefat fixed striped posts dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Branch</th>
							<th>Name</th>
							<th>Date</th>
							<th>Ratings</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$ctr = 1;
						while($row = $table->fetch_assoc()){
							$rating = (($row['Service'] + $row['WillRecommend'] + $row['TotalExperience'])/ 3);
							$status = "";
							$color = "";
							if($row['Status'] == 1){
								$status = "Enabled";
								$color = "green";	
							}else{
								$status = "Disabled";
								$color = "red";	
							}
							echo '
								<tr>
									<td>'.$ctr.'</td>
									<td>'.$row['Branch'].'</td>
									<td>
										<strong>'.$row['FirstName'].' '.$row['LastName'].'</strong>
										<div class="row-actions">
											<span class="view">
												<a href="#TB_inline?width=600&height=650&inlineId=rating-view" class="thickbox view-review "   data-branch="'.$row['Branch'].'" data-reviewid="'.$row['ReviewID'].'" data-reviewerid="'.$row['ReviewerID'].'" data-state="'.$row['State'].'" data-city="'.$row['City'].'" data-review="'.$row['Review'].'" data-summary="'.$row['ReviewSummary'].'" data-experience="'.$row['TotalExperience'].'" data-recommend="'.$row['WillRecommend'].'" data-service="'.$row['Service'].'" data-fname="'.$row['FirstName'].'" data-lname="'.$row['LastName'].'" class="view-review"  >View</a> |  
											</span>
											<span class="trash">
												<a href="'.get("?mode=deactivate&id=".$row['ReviewID']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="submitdelete">Trash</a>
											</span>
										</div>
									</td> 
									<td>'.date('M d, Y',strtotime($row['DateSubmitted'])).'</td>
									<td>'.$rating.'</td>
									<td style="font-weight:bold; color:'.$color.'" >'.$status.'</td>	
								</tr>					
							';
							$ctr++;
						}
					?>

					</tbody>
				</table>				 
			</div>

			<div id="trash-review-tab" class="tab_content">
				<table class="data-table wp-list-table widefat fixed striped posts dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Branch</th>
							<th>Name</th>
							<th>Date</th>
							<th>Ratings</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$ctr = 1;
						while($row = $trash->fetch_assoc()){
							$rating = (($row['Service'] + $row['WillRecommend'] + $row['TotalExperience'])/ 3);
							$status = "";
							$color = "";
							if($row['Status'] == 1){
								$status = "Enabled";
								$color = "green";	
							}else{
								$status = "Disabled";
								$color = "red";	
							}
							echo '
								<tr>
									<td>'.$ctr.'</td>
									<td>'.$row['Branch'].'</td>
									<td>
										<strong>'.$row['FirstName'].' '.$row['LastName'].'</strong>
										<div class="row-actions">
											<span class="view">
												<a href="#TB_inline?width=600&height=650&inlineId=rating-view" class="thickbox view-review " data-reviewid="'.$row['ReviewID'].'" data-branch="'.$row['Branch'].'" data-reviewerid="'.$row['ReviewerID'].'" data-state="'.$row['State'].'" data-city="'.$row['City'].'" data-review="'.$row['Review'].'" data-summary="'.$row['ReviewSummary'].'" data-experience="'.$row['TotalExperience'].'" data-recommend="'.$row['WillRecommend'].'" data-service="'.$row['Service'].'" data-fname="'.$row['FirstName'].'" data-lname="'.$row['LastName'].'" class="view-review"  >View</a> |  
											</span>
											<span class="restore">
												<a href="'.get("?mode=activate&id=".$row['ReviewID']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="submitdelete">Restore</a>
											</span>
										</div>
									</td> 
									<td>'.date('M d, Y',strtotime($row['DateSubmitted'])).'</td>
									<td>'.$rating.'</td>
									<td style="font-weight:bold; color:'.$color.'" >'.$status.'</td>	
								</tr>					
							';
							$ctr++;
						}
					?>

					</tbody>
				</table>	
			</div>

			
		</div>
<!--MODAL-->
					<?php add_thickbox(); ?>
					<div id="rating-view" style="display:none;">
						<form id="rating-view-form" action="<?=plugins_url('/data/post.php',__FILE__ )?>" method="POST" >
							<input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI']?>"/>
							<input type="hidden" id="ReviewID" name="ReviewID" />
							<input type="hidden" id="ReviewerID" name="ReviewerID" />
							<table>
								<tr>
									<td><label>Branch</label></td>
									<td><input type="text" id="branch" name="branch" readonly /></td>
								</tr>
								<tr>
									<td><label>Name</label></td>
									<td><input type="text" id="fname" name="fname"  /></td>
									<td><input type="text" id="lname" name="lname" /></td>
								</tr>
								<tr>
									<td><label>State</label></td>
									<td colspan="2">		
										<input type="text" id="state" name="state"  />
									</td>
								</tr>
								<tr>
									<td><label>City</label></td>
									<td colspan="2">		
										<input type="text" id="city" name="city"  />
									</td>
								</tr>
								<tr>
									<td><label>Service</label></td>
									<td colspan="2">		
										<select name="service" id="service">
											<?php
												for($x = 1 ; $x <= 5 ; $x++ ){
													echo "<option value=".$x.">".$x."</option>";
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td><label>Will Recommend</label></td>
									<td colspan="2">		
										<select name="recommend" id="recommend">
											<?php
												for($x = 1 ; $x <= 5 ; $x++ ){
													echo "<option value=".$x.">".$x."</option>";
												}
											?>
										</select>
									</td>
								</tr>		
								<tr>
									<td><label>Total Experience</label></td>
									<td colspan="2"> 		
										<select name="experience" id="experience">
											<?php
												for($x = 1 ; $x <= 5 ; $x++ ){
													echo "<option value=".$x.">".$x."</option>";
												}
											?>
										</select> 
									</td>
								</tr>	
								<tr>	
									<td><label>Review Summary:</label></td>
									<td colspan="2"><textarea rows="5" id="review-summary" name="summary"  ></textarea></td>
								</tr>
								<tr>	
									<td><label>Review:</label></td>
									<td colspan="2"><textarea rows="5" id="review" name="review"  ></textarea></td>
								</tr>								
								<tr align="right">
									<td colspan="3"><button class="button button-primary" name="btnEdit">Save</button></td>
								</tr>
						
							
						</form>
					</table>
					</div>
<?php
} 
function pv_feedback(){
	require_once('data/display_model.php');
	require_once('data/edit_model.php');
	
	$get = new display_model();
	$edit = new edit_model();
	
	$viewFeedback = $edit->view_feedback();
	$feedback = $get->get_feed_back_name();
 ?>
	
	<h2 class="pv-h2">Private Feedbacks</h2>
 <table class="data-table wp-list-table widefat fixed striped posts dataTable">
					<thead>
						<tr role="row">
							<th>#</th>
							<th>Branch</th>
							<th>Name</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
						$ctr = 1;
						while($row = $feedback->fetch_assoc()){
						
							echo '
								<tr>
									<td>'.$ctr.'</td>
									<td>'.$row['Branch'].'</td>
									<td>
										<strong>'.$row['FirstName'].' '.$row['LastName'].'</strong>
										<div class="row-actions">
											<span class="view">
												<a  data-dir="'.get_home_path().'" data-url="'. plugins_url( '/jpc/templates', dirname(__FILE__) ).'" data-id="'.$row['ReviewerID'].'" data-name="'.$row['FirstName'].' '.$row['LastName'].'" href="#TB_inline?width=600&height=650&inlineId=feedback-view" class="thickbox view-feedback "  >View Feedback</a> |
											</span>
											<span class="trash">
												<a href="'.get("?mode=delete_feedback&id=".$row['ReviewerID']."&redirect=".$_SERVER['REQUEST_URI']."").'">Delete</a>
											</span>
										</div>
									</td> 
									<td>'.date('M d, Y',strtotime($row['DateSubmitted'])).'</td>

								</tr>					
							';
							$ctr++;
						}
					?>

					</tbody>
				</table>	
				<?php add_thickbox(); ?>
					<div id="feedback-view" style="display:none;">
						<label class="feedback_name"></label>
						<div class="feedback-container">
						</div>
					</div>
 <?php
}
function pv_rating_settings(){
 ?>
	<h2 class="pv-h2">PV Ratings Settings</h2>
	<form method="post" action="options.php">
		<?=settings_fields( 'pv-option-group' );?>
		<?=do_settings_sections( 'pv-option-group' );?>
		<?php
			echo '<table>
				<h2>Chandler</h2>
				<tr>
					<td>Google Review Link</td>
					<td><input placeholder="Google Review" type="text" name="google_review_chandler" value="'. esc_attr( get_option('google_review_chandler') ).'" /></td>
				</tr>
				<tr>
					<td>Yelp Review Link</td>
					<td><input placeholder="Yelp Review" type="text" name="yelp_review_chandler" value="'. esc_attr( get_option('yelp_review_chandler') ).'" /></td>
				</tr>
				<tr>
					<td>Angie\'s List Review Link</td>
					<td><input placeholder="Angie\'s List Review" type="text" name="angies_review_chandler" value="'. esc_attr( get_option('angies_review_chandler') ).'" /></td>
				</tr>
				<tr>
					<td>Facebook Review Link</td>
					<td><input placeholder="Facebook Review" type="text" name="facebook_review_chandler" value="'. esc_attr( get_option('facebook_review_chandler') ).'" /></td>
				</tr>
			</table>';
		?>
		<?php
			echo '<table>
				<h2>Scottsdale</h2>
				<tr>
					<td>Google Review Link</td>
					<td><input placeholder="Google Review" type="text" name="google_review_scottsdale" value="'. esc_attr( get_option('google_review_scottsdale') ).'" /></td>
				</tr>
				<tr>
					<td>Yelp Review Link</td>
					<td><input placeholder="Yelp Review" type="text" name="yelp_review_scottsdale" value="'. esc_attr( get_option('yelp_review_scottsdale') ).'" /></td>
				</tr>
				<tr>
					<td>Angie\'s List Review Link</td>
					<td><input placeholder="Angie\'s List Review" type="text" name="angies_review_scottsdale" value="'. esc_attr( get_option('angies_review_scottsdale') ).'" /></td>
				</tr>
				<tr>
					<td>Facebook Review Link</td>
					<td><input placeholder="Facebook Review" type="text" name="facebook_review_scottsdale" value="'. esc_attr( get_option('facebook_review_scottsdale') ).'" /></td>
				</tr>
			</table>';
		?>		
		<?php submit_button(); ?>
	</form>
	<?php
}
function pv_save_settings_post() {
	register_setting( 'pv-option-group', 'google_review_chandler' );
	register_setting( 'pv-option-group', 'yelp_review_chandler' );
	register_setting( 'pv-option-group', 'angies_review_chandler' );
	register_setting( 'pv-option-group', 'facebook_review_chandler' );
	
	register_setting( 'pv-option-group', 'google_review_scottsdale' );
	register_setting( 'pv-option-group', 'yelp_review_scottsdale' );
	register_setting( 'pv-option-group', 'angies_review_scottsdale' );
	register_setting( 'pv-option-group', 'facebook_review_scottsdale' );
}
add_action( 'admin_init', 'pv_save_settings_post' ); 
?>