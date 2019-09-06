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
	
	$mypage = add_menu_page( 
		'PV Intake Form Rotator', 				// Page Title
		'PV Intake Form Rotator'.$ratings.'',	// Navbar Title
		'manage_options',      					// Permission 
		'pv-intake-form',      					// Page ID
		'pvintake_main_page',           		// Function call
		'dashicons-format-aside',   			// Favicon
		2                				 	    // Order
	);

	add_action( 'load-' . $mypage, 'load_styles_js' );

}

function load_styles_js() {
	add_action('admin_enqueue_scripts','enqueue_admin_script');
	add_action('admin_enqueue_scripts','enqueue_admin_style');
}

function enqueue_admin_script(){
	wp_enqueue_script('pvintake-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	
}

function enqueue_admin_style(){
	echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https:">';

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
 <div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="pv-h2">Primeview Intake Form Rotator</h2>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
					<a class="nav-link" id="v-pills-pending-tab" data-toggle="pill" href="#v-pills-pending" role="tab" aria-controls="v-pills-pending" aria-selected="false">Pending Intakes</a>
					<a class="nav-link" id="v-pills-approve-tab" data-toggle="pill" href="#v-pills-approve" role="tab" aria-controls="v-pills-approve" aria-selected="false">Approved Intakes</a>
					<a class="nav-link" id="v-pills-decline-tab" data-toggle="pill" href="#v-pills-decline" role="tab" aria-controls="v-pills-decline" aria-selected="false">Declined Intakes</a>
					<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="true">Settings</a>
				</div>
			</div>
			<div class="col-9">
				<div class="tab-content" id="v-pills-tabContent">
					
					<!-- Home -->
					<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div align="center">
										<h1 class="pv-h2">Primeview Intake Form Rotator</h1>
										<p>
											A plugin that will get all intake form information and insert in on a slider.
											This plugin also allow intake approvals before showing it on the slider
										</p>
									</div>
									<div align="center">
										<h3>Usage</h3>
										<p>	
											<i>Intake Form Shortcode:</i> <br>
											<b>[pv-intake-form]</b>
										</p>
										<p>	
											<i>Content Slider Shortcode: </i><br>
											<b>[view-intake-form]</b>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Pending Intakes -->
					<div class="tab-pane fade" id="v-pills-pending" role="tabpanel" aria-labelledby="v-pills-pending-tab">
						<table class="table table-hover data-table">
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
					<div class="tab-pane fade" id="v-pills-approve" role="tabpanel" aria-labelledby="v-pills-approve-tab">
						<table class="table table-hover data-table">
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
					<div class="tab-pane fade" id="v-pills-decline" role="tabpanel" aria-labelledby="v-pills-decline-tab">
						<table class="table table-hover data-table">
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
					
					<!-- Plugin Settings -->
					<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
								   	<div align="center">
										<h2 class="pv-h2">PV Intake Form Settings</h2>
									</div>
									<form method="post" action="options.php">
										<?=settings_fields( 'pvintake-option-group' );?>
										<?=do_settings_sections( 'pvintake-option-group' );?>
								   		<div class="container">
											<div class="row">
								   				<div class="col-md-6">
								   					<h3>Card Settings</h3>
												   <div class="card-settings">
												   		<div class="form-group">
															<label>Background Color</label>
															<input type="color" name="card_bgcolor" value="<?=esc_attr( get_option('card_bgcolor') )?>">
														</div>
														<div class="form-group">
															<label>Font Color</label>
															<input type="color" name="card_fontcolor" value="<?=esc_attr( get_option('card_fontcolor') )?>">
														</div>
														<div class="form-group">
															<label>Margin</label>
															<input type="number" class="form-control" name="card_margin" value="<?=esc_attr( get_option('card_margin') )?>" min="0">
														</div>
														<div class="form-group">
															<label>Padding</label>
															<input type="number" class="form-control" name="card_padding" value="<?=esc_attr( get_option('card_padding') )?>" min="0">
														</div>
														<div class="form-group">
															<label>Height</label>
															<input type="number" class="form-control" name="card_height" value="<?=esc_attr( get_option('card_height') )?>" min="0">
														</div>

														<div class="form-group">
															<label>Width</label>
															<input type="number" class="form-control" name="card_width" value="<?=esc_attr( get_option('card_width') )?>" min="0">
														</div>
													</div>
												</div>
										   	</div>
											
											<div class="row">
												<div class="col-md-6">
													<h3>Owl Carousel Settings</h3>
													<div class="owl-settings">
														<div class="form-group">
															<label>No. of Items</label>
															<input type="number" class="form-control" name="owl_items" value="<?=esc_attr( get_option('owl_items') )?>" min="1">
														</div>
														<div class="form-group">
															<label>Margin</label><br>
															<input type="number" class="form-control" name="owl_margin" value="<?=esc_attr( get_option('owl_margin') )?>" min="1">
														</div>
														<div class="form-group">
															<label>Loop?</label><br>
															<label class="radio-inline"><input type="radio" name="owl_loop" value="true" <?=(esc_attr( get_option('owl_loop') )) === "true" ? "checked" : "" ?>>Yes</label>
															<label class="radio-inline"><input type="radio" name="owl_loop" value="false" <?=(esc_attr( get_option('owl_loop') )) === "false" ? "checked" : "" ?>>No</label>
														</div>
														<div class="form-group">
															<label>Autoplay?</label><br>
															<label class="radio-inline"><input type="radio" name="owl_autoplay" value="true" <?=(esc_attr( get_option('owl_autoplay') )) === "true" ? "checked" : "" ?>>Yes</label>
															<label class="radio-inline"><input type="radio" name="owl_autoplay" value="false" <?=(esc_attr( get_option('owl_autoplay') )) === "false" ? "checked" : "" ?>>No</label>
														</div>
														<div class="form-group">
															<label>Autoplay timeout</label><br>
															<input type="number" class="form-control" name="owl_aptimeout" value="<?=esc_attr( get_option('owl_aptimeout') )?>" min="1"> <span><em>ms</em></span>
														</div>
													</div>
												</div>
											</div>
											<div class="row mt-3">	
								   				<div class="col-md-12">
								   					<input type="submit" class="btn btn-primary" value="Save Changes"/>
												</div>
											</div>
										</div>
									</form>
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
</div>
<?php
} 
function pv_intake_save_settings_post() {

	//Default options
	add_option( 'card_bg', '#007EEC' );
	add_option( 'card_fontcolor', '#FFFFFF' );
	add_option( 'card_margin', '10' );
	add_option( 'card_padding', '10' );
	add_option( 'card_height', '150' );
	add_option( 'card_width', '150' );

	add_option( 'owl_items', '3' );
	add_option( 'owl_loop', 'true' );
	add_option( 'owl_autoplay', 'true' );
	add_option( 'owl_margin', '10' );
	add_option( 'owl_aptimeout', '1000' );

	register_setting( 'pvintake-option-group', 'card_bgcolor' );
	register_setting( 'pvintake-option-group', 'card_fontcolor' );
	register_setting( 'pvintake-option-group', 'card_margin' );
	register_setting( 'pvintake-option-group', 'card_padding' );
	register_setting( 'pvintake-option-group', 'card_height' );
	register_setting( 'pvintake-option-group', 'card_width' );

	register_setting( 'pvintake-option-group', 'owl_items' );
	register_setting( 'pvintake-option-group', 'owl_loop' );
	register_setting( 'pvintake-option-group', 'owl_autoplay' );
	register_setting( 'pvintake-option-group', 'owl_margin' );
	register_setting( 'pvintake-option-group', 'owl_aptimeout' );
}
add_action( 'admin_init', 'pv_intake_save_settings_post' ); 
?>