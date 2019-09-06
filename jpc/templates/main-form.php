<?php
if(isset($_GET['msg']) && ($_GET['msg'] == 'success') ) {$return .='<div class="pv-success"><p>Thanks! Your Response has been submitted!</p></div>';}
$return .= '
	<div class="container-intake-form">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<form action="'.plugins_url().'/pv-intake-form-rotator/jpc/data/post.php'.'" method="POST" >
						<input type="hidden" name="intake_redirect" value="'.$_SERVER['REQUEST_URI'].'"/>
						<div class="form-group">
							<label for="From">From</label>
							<input type="text" class="form-control" name="pv_from" placeholder="Enter Name" required>
						</div>
						<div class="form-group">
							<label for="From">To</label>
							<input type="text" class="form-control" name="pv_to" placeholder="Enter Name" required>
						</div>
						<div class="form-group">
							<label for="From">Message</label>
							<textarea class="form-control" name="pv_message" placeholder="Enter Message" required></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="intake_submit" class="btn btn-primary" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
';

return $return;