<?php
/**
 * Create admin Page to list unsubscribed emails.
**/

// Hook for adding admin menus
	add_action('admin_menu', 'create_intake_page');
// action function for above hook
 
/**
* Adds a new top-level page to the administration menu.
**/
function get_data($strings){
	return plugins_url('/data/get.php'.$strings.'',__FILE__ );
}
function pv_intake_form(){
	return require_once('templates/main-form.php');
}
add_shortcode( 'pv-intake-form' , 'pv_intake_form' );

function view_intake_form(){
	return require_once('templates/view-review.php');
}
add_shortcode( 'view-intake-form' , 'view_intake_form' );


function create_intake_page(){
	

	$ratings = '<span class="update-plugins count-'.get_notif().'"><span class="plugin-count">'.get_notif().'</span></span>';
	
	add_menu_page( 
		'PV Intake Form Rotator', 				// Page Title
		'PV Intake Form Rotator'.$ratings.'',	// Navbar Title
		'manage_options',      					// Permission 
		'pv-intake-form',      					// Page ID
		'pvintake_main_page',           		// Function call
		'dashicons-format-aside',   			// Favicon
		2                				 	    // Order
	);
}
function get_notif(){
	require_once('data/display_model.php');
	$get = new display_model();
	
	$ratings = $get->get_notif(); //2 = Pending;
	
	return $ratings;
}
//Page Proper
function pvintake_main_page(){
	require_once('data/display_model.php');
	// require_once('data/edit_model.php');
	
	$get  = new display_model();
	// $edit = new edit_model();
	
	$approved = $get->show_all_intake_by_status(1);
	$pending = $get->show_all_intake_by_status(2);
	$trash = $get->show_all_intake_by_status(0); 
	
	// //Update isViewed
	// $isViewed =  $edit->isViewed();
 ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1 class="pv-h2">Primeview Intake Form Rotator</h1>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Pending Intakes</a>
					<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Approved Intakes</a>
					<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Declined Intakes</a>
					<a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Settings</a>
				</div>
			</div>
			<div class="col-9">
				<div class="tab-content" id="v-pills-tabContent">
					<!-- Pending Intakes -->
					<div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">From</th>
								<th scope="col">To</th>
								<th scope="col">Date Submitted</th>
								<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = $pending->fetch_assoc()){
									echo '
									<tr>
										<td>' . $row['intake_id'] . '</td>
										<td>' . $row['name_from'] . '</td>
										<td>' . $row['name_to'] . '</td>
										<td>' . $row['date_answered'] . '</td>
										<td>	
											<button class="btn btn-primary view-intake" 
											data-toggle="modal" 
											data-target="#view_intake"
											id="' . $row['intake_id'] . '" 
											data-to-' . $row['intake_id'] . '="' . $row['name_to'] . '" 
											data-from-' . $row['intake_id'] . '="' . $row['name_from'] . '"
											data-msg-' . $row['intake_id'] . '="' . $row['intake_message'] . '"
											data-date-' . $row['intake_id'] . '="' . $row['date_answered'] . '">
												<i class="fas fa-eye"></i>
											</button>
											<a href="'.get_data("?mode=activate&id=".$row['intake_id']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="btn btn-success">
												<i class="fas fa-check-square"></i>
											</a>
											<a href="'.get_data("?mode=deactivate&id=".$row['intake_id']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="btn btn-danger">
											<i class="fas fa-times-circle"></i>
											</a>
										</td>
									</tr>';
							   	}?>
							</tbody>
						</table>
					</div>

					<!-- Approved Intakes -->
					<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">From</th>
								<th scope="col">To</th>
								<th scope="col">Date Submitted</th>
								<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php while($row = $approved->fetch_assoc()){
									echo '
									<tr>
										<td>' . $row['intake_id'] . '</td>
										<td>' . $row['name_from'] . '</td>
										<td>' . $row['name_to'] . '</td>
										<td>' . $row['date_answered'] . '</td>
										<td>	
											<button class="btn btn-primary view-intake" 
											data-toggle="modal" 
											data-target="#view_intake"
											id="' . $row['intake_id'] . '" 
											data-to-' . $row['intake_id'] . '="' . $row['name_to'] . '" 
											data-from-' . $row['intake_id'] . '="' . $row['name_from'] . '"
											data-msg-' . $row['intake_id'] . '="' . $row['intake_message'] . '"
											data-date-' . $row['intake_id'] . '="' . $row['date_answered'] . '">
												<i class="fas fa-eye"></i>
											</button>
											<a href="'.get_data("?mode=deactivate&id=".$row['intake_id']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="btn btn-danger">
												<i class="fas fa-times-circle"></i>
											</a>
										</td>
									</tr>';	
							   	}?>
							</tbody>
						</table>
					</div>

					<!-- Declined Intakes -->
					<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">From</th>
								<th scope="col">To</th>
								<th scope="col">Date Submitted</th>
								<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php while($row = $trash->fetch_assoc()){
									echo '
									<tr>
										<td>' . $row['intake_id'] . '</td>
										<td>' . $row['name_from'] . '</td>
										<td>' . $row['name_to'] . '</td>
										<td>' . $row['date_answered'] . '</td>
										<td>	
											<button class="btn btn-primary view-intake" 
											data-toggle="modal" 
											data-target="#view_intake"
											id="' . $row['intake_id'] . '" 
											data-to-' . $row['intake_id'] . '="' . $row['name_to'] . '" 
											data-from-' . $row['intake_id'] . '="' . $row['name_from'] . '"
											data-msg-' . $row['intake_id'] . '="' . $row['intake_message'] . '"
											data-date-' . $row['intake_id'] . '="' . $row['date_answered'] . '">
												<i class="fas fa-eye"></i>
											</button>
											<a href="'.get_data("?mode=activate&id=".$row['intake_id']."&redirect=".$_SERVER['REQUEST_URI']."").'" class="btn btn-success">
												<i class="fas fa-check-square"></i>
											</a>
										</td>
									</tr>';	
							   	}?>
							</tbody>
						</table>
					</div>

					<div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<table style="margin-left: 22px;margin-bottom: 17px;font-weight: bold;">
										<tbody>
										<tr>
											<td>Form Shortcode : </td>
											<td>[pv-intake-form]</td>
										</tr>
										<tr>
											<td>View Reviews Shortcode : </td>
											<td>[view-intake-form]</td>
										</tr>
										</tbody>
									</table>
								</div>	
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="view_intake" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">View Intakes</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>To</label>
						<input type="text" id="data-to" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label>From</label>
						<input type="text" id="data-from" class="form-control" readonly/>
					</div>
					<div class="form-group">
						<label>Message</label>
						<textarea id="data-msg" class="form-control" readonly></textarea>
					</div>
					<div class="form-group">
						<label>Date Submitted</label>
						<input type="text" id="data-date" class="form-control" readonly/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php
} 
function pv_intake_settings(){
 ?>
	<h2 class="pv-h2">PV Ratings Settings</h2>
	<form method="post" action="options.php">
		<?=settings_fields( 'pvintake-option-group' );?>
		<?=do_settings_sections( 'pvintake-option-group' );?>
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
function pv_intake_save_settings_post() {
	register_setting( 'pvintake-option-group', 'google_review_chandler' );
	register_setting( 'pvintake-option-group', 'yelp_review_chandler' );
	register_setting( 'pvintake-option-group', 'angies_review_chandler' );
	register_setting( 'pvintake-option-group', 'facebook_review_chandler' );
	
	register_setting( 'pvintake-option-group', 'google_review_scottsdale' );
	register_setting( 'pvintake-option-group', 'yelp_review_scottsdale' );
	register_setting( 'pvintake-option-group', 'angies_review_scottsdale' );
	register_setting( 'pvintake-option-group', 'facebook_review_scottsdale' );
}
add_action( 'admin_init', 'pv_intake_save_settings_post' ); 
?>