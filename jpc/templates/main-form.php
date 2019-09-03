<?php
require_once(plugin_dir_path( __FILE__ ).'../data/display_model.php'); 

$get = new display_model();
$questions = $get->getAllQuestions();
$return = 
'
	<div class="rating-main-form">';
	if(isset($_GET['msg']) && ($_GET['msg'] == 'success') ) {$return .='<div class="pv-success"><h4>Thanks! Your Response has been submitted!</h4></div>';}
		$return .='
		<div class="pv-body">
			<div class="pv-site-info">
				
			</div>
			<div class="pv-title"><h4>Write a Review</h4></div>
			<div id="pv-review">
				<form action="'.plugins_url().'/primeview-plugin/jpc/data/post.php'.'" method="POST" >
				<input type="hidden" name="redirect" value="'.$_SERVER['REQUEST_URI'].'"/>
				<div class="wrap grid first-part">
					<div class="review-forms-third-party unit w-1-1">
						<div class="wrap grid social-reviews chandler">
						<h2>Chandler</h2>
						';
						$sep_count = 0;
						if(get_option('google_review_chandler')){
							$sep_count++;
						}
						if(get_option('yelp_review_chandler')){
							$sep_count++;
						}
						if(get_option('angies_review_chandler')){
							$sep_count++;
						}
						if(get_option('facebook_review_chandler')){
							$sep_count++;
						}						
						if(get_option('google_review_chandler')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/google-logo.png" alt="Google Review" title="Google Review" /><a href="'.get_option('google_review_chandler').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/google-review-button.png" alt="Google review" title="Google Review" /></a></div>'; }
						if(get_option('yelp_review_chandler')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/yelp-logo.png" alt="Yelp Review" title="Yelp Review" /><a href="'.get_option('yelp_review_chandler').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/yelp-review-button.png" alt="Yelp Review" title="Yelp Review" /></a></div>'; }
						if(get_option('angies_review_chandler')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/angies_review.png" alt="Angies List Review" title="Angies List Review" /><a href="'.get_option('angies_review_chandler').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/angies_review.png" alt="Angies List Review" title="Angies List Review" /></a></div>'; }
						if(get_option('facebook_review_chandler')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/facebook-logo.png" alt="Facebook Review" title="Facebook Review" /><a href="'.get_option('facebook_review_chandler').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/facebook-review-button.png" alt="Facebook Review" title="Facebook Review" /></a></div>'; }
						$return .='</div>
					</div>
					
					<div class="review-forms-third-party unit w-1-1">
						<div class="wrap grid social-reviews scottsdale">
						<h2>Scottsdale</h2>
						';
						$sep_count = 0;
						if(get_option('google_review_scottsdale')){
							$sep_count++;
						}
						if(get_option('yelp_review_scottsdale')){
							$sep_count++;
						}
						if(get_option('angies_review_scottsdale')){
							$sep_count++;
						}
						if(get_option('facebook_review_scottsdale')){
							$sep_count++;
						}						
						if(get_option('google_review_scottsdale')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/google-logo.png" alt="Google Review" title="Google Review" /><a href="'.get_option('google_review_scottsdale').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/google-review-button.png" alt="Google review" title="Google Review" /></a></div>'; }
						if(get_option('yelp_review_scottsdale')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/yelp-logo.png" alt="Yelp Review" title="Yelp Review" /><a href="'.get_option('yelp_review_scottsdale').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/yelp-review-button.png" alt="Yelp Review" title="Yelp Review" /></a></div>'; }
						if(get_option('angies_review_scottsdale')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/angies_review.png" alt="Angies List Review" title="Angies List Review" /><a href="'.get_option('angies_review_scottsdale').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/angies_review.png" alt="Angies List Review" title="Angies List Review" /></a></div>'; }
						if(get_option('facebook_review_scottsdale')){ $return .='<div class="unit w-1-'.$sep_count.'"><img class="social-logo" src="'.plugins_url().'/primeview-plugin/admin/img/facebook-logo.png" alt="Facebook Review" title="Facebook Review" /><a href="'.get_option('facebook_review_scottsdale').'" target="_blank"><img src="'.plugins_url().'/primeview-plugin/admin/img/facebook-review-button.png" alt="Facebook Review" title="Facebook Review" /></a></div>'; }
						$return .='</div>
					</div>
					
					<div class="pv-b unit w-1-1">
						<h5>Click on the Stars to Rate</h5>
						<div class="review-form wrap grid">
							<div class="unit w-1-3 star-rating-1">
								<label class="pv-label">Service</label>
								<fieldset class="rating service-rating">
									<input required type="radio" id="star5"		name="pv_service_rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
									<input type="radio" id="star4"				name="pv_service_rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
									<input type="radio" id="star3"				name="pv_service_rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
									<input type="radio" id="star2"				name="pv_service_rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
									<input type="radio" id="star1"				name="pv_service_rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
								</fieldset>
							</div>
							<div class="unit w-1-3 star-rating-2">
								<label class="pv-label">Will Recommend</label>
								<fieldset class="rating recommend-rating">
									<input required type="radio" id="2star5"	name="pv_recommend_rating" value="5" /><label class = "full" for="2star5" title="Awesome - 5 stars"></label>						
									<input type="radio" id="2star4"				name="pv_recommend_rating" value="4" /><label class = "full" for="2star4" title="Pretty good - 4 stars"></label>
									<input type="radio" id="2star3"				name="pv_recommend_rating" value="3" /><label class = "full" for="2star3" title="Meh - 3 stars"></label>
									<input type="radio" id="2star2"				name="pv_recommend_rating" value="2" /><label class = "full" for="2star2" title="Kinda bad - 2 stars"></label>
									<input type="radio" id="2star1"				name="pv_recommend_rating" value="1" /><label class = "full" for="2star1" title="Sucks big time - 1 star"></label>
								</fieldset>
							</div>
							<div class="unit w-1-3 star-rating-3">
								<label class="pv-label">Total Experience</label>
								<fieldset class="rating total-exp-rating">
									<input required type="radio" id="3star5"	name="pv_total_exp_rating" value="5" /><label class = "full" for="3star5" title="Awesome - 5 stars"></label>
									<input type="radio" id="3star4"				name="pv_total_exp_rating" value="4" /><label class = "full" for="3star4" title="Pretty good - 4 stars"></label>
									<input type="radio" id="3star3"				name="pv_total_exp_rating" value="3" /><label class = "full" for="3star3" title="Meh - 3 stars"></label>
									<input type="radio" id="3star2"				name="pv_total_exp_rating" value="2" /><label class = "full" for="3star2" title="Kinda bad - 2 stars"></label>
									<input type="radio" id="3star1"				name="pv_total_exp_rating" value="1" /><label class = "full" for="3star1" title="Sucks big time - 1 stars"></label>
								</fieldset>
							</div>
						</div>
						<div class="branch-selector-container">
							<label class="pv-label">Select Branch<sup>*</sup></label>
							<select name="pvBranchSelector" required >
								<option selected disabled>Select Branch...</option>
								<option value="Chandler">Chandler</option>
								<option value="Scottsdale">Scottsdale</option>
							</select>
						</div>
						<div class="review-summary-container">
							<label class="pv-label">Review Summary<sup>*</sup></label>
							<input type="text" name="pvReviewSummary" required />
						</div>
						<div class="review-container">
							<label class="pv-label">Review<sup>*</sup></label>
							<textarea rows="5" name="pvReviewReview" required></textarea>
						</div>
					</div>

				</div>
				<div class="pv-title"><h4>Your Info</h4></div>
				<div class="wrap grid second-part">
					<div class="unit w-1-2 field-1">	
						<label class="pv-label">First Name<sup>*</sup></label>
						<input type="text" name="pv_first_name" required/>
					</div>
					<div class="unit w-1-2 field-2">	
						<label class="pv-label">Last Name<sup>*</sup></label>
						<input type="text" name="pv_last_name" required/>

					</div>
					<div class="unit w-1-2 field-3">
									<label class="pv-label">City<sup>*</sup></label>
						<input type="text" name="pv_city" required />			
					</div>	
					<div class="unit w-1-2 field-4">
						<label class="pv-label">State<sup>*</sup></label>
						<select name="pv_state" required>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>									
					</div>	
				</div>
				<div class="pv-sub-title"><h4>Private Feedback <span>(Optional)</span></h4></div>
					<div class="pv-private-feedback">
					';
						while($row = $questions->fetch_assoc()){
							$return .='
								<label>'.$row['Question'].'</label>
								<input type="text" name="question[1]['.$row['QuestionID'].']" />
							';
						}
						$return.='
					<button type="button" name="pv_submit" class="pv_submit">Submit Review</button>
					</div>
				</form>
				</div>
			</div>
		</div>
';

return $return;