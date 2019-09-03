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
	

	// $ratings = '<span class="update-plugins count-'.getNotif('ratings').'"><span class="plugin-count">'.getNotif('ratings').'</span></span>';
	// $feedback = '<span class="update-plugins count-'.getNotif('feedback').'"><span class="plugin-count">'.getNotif('feedback').'</span></span>';
	
	add_menu_page( 
		'PV Intake Form Rotator', 				// Page Title
		'PV Intake Form Rotator'.$ratings.'',	// Navbar Title
		'manage_options',      					// Permission 
		'pv-intake-form',      					// Page ID
		'main_page',           			 	  	// Function call
		'dashicons-star-filled',   				// Favicon
		2                				 	    // Order
	);
 
	add_submenu_page( 
		'primeview-rating',      			 		 // Parent Page ID
		'PV Intake Settings',     		 				 // Page Title
		'Settings', 						 // Navbar Title
		'manage_options', 						 // Permission 	
		'pv-settings', 							 // Submenu Page ID
		'pv_rating_settings' 								 // Function  call	 
	); 	
}
function getNotif($mode){
	require_once('data/display_model.php');
	$get = new display_model();
	
	$ratings = $get->get_notif(); //2 = Pending;
	
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
	
	$table = $get->show_all_intake_by_status(1)->fetch_assoc();
	$pending = $get->show_all_intake_by_status(2)->fetch_assoc();
	$trash = $get->show_all_intake_by_status(0)->fetch_assoc(); 
	
	// //Update isViewed
	// $isViewed =  $edit->isViewed();
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
				<?php
					$ctr = 1;
					print_r($pending);	
				?>	
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