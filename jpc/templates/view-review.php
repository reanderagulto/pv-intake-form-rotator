<?php
require_once(plugin_dir_path( __FILE__ ).'../data/display_model.php'); 
$array = array();
$get = new display_model();
$reviews = $get->getAllReviews();
$return = '
<style>
    ul, li{
            list-style: none;
        }
        #wrapper{
            width: 900px;
            margin: 20px auto;
        }
        .data-container{
            margin-top: 5px;
        }
        .data-container ul{
            padding: 0;
            margin: 0;
        }
        .data-container li{
            margin-bottom: 5px;
            padding: 5px 10px;
            background: #eee;
            color: #666;
        }
</style>
<div class="rating-main-form">
		<div class="pv-body">
			<div class="pv-site-info">
				
			</div>
			<div class="pv-title"><h4>Reviews</h4></div>
			<div id="pv-review">
				<div class="view-review">';
				if($reviews->num_rows!=0){
					while($row = $reviews->fetch_assoc()){
					
					$star = "";
					$fields = array( $row['Service'],$row['WillRecommend'],$row['TotalExperience'] ); 
					$rating = round((array_sum($fields)) / 3);
					
					if ($rating == 5){
						$star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					}else if ($rating == 4){
						$star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					}else if ($rating == 3){
						$star = "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
					}else if ($rating == 2){
						$star = "<i class='fa fa-star'></i><i class='fa fa-star'></i>";
					}else if ($rating == 1){
						$star = "<i class='fa fa-star'></i>";
					}
					$layers = '<div class="wrap grid">
									<div class="unit w-1-4">
										<div class="pv-review-image"><img src="'.plugin_dir_url(__FILE__).'../../admin/img/default-medium.png" title="" alt="" /></div>
										<span class="pv-reviewer">'.$row['FirstName'].' '.$row['LastName'].'</span>
										<span class="pv-address">'.$row['City'].', '.$row['State'].'</span>
										<span class="pv-date">'.date('m/d/Y',strtotime($row['DateSubmitted'])).'</span>
									</div>
									<div class="unit w-3-4">
										<div class="pv-star-rating">'.$star.'</div>
										<div class="pv-review-summary">'.$row['ReviewSummary'].'</div>
										<div class="pv-review">
											'.$row['Review'].'
											
										</div>
									</div>
								</div>';
						$array[] =  $layers;	
						}
					}else{
						$array[] = "No Available data.";
					}
				
				$return .='	
					<div class="review-container"></div>
					<div class="review-layers"></div>
				</div> 
			</div>
		</div>
	</div>
<script>
	$ = jQuery.noConflict();
	$(function(){
		 createPage(".review-layers",'.json_encode($array).');
	});
</script>
	';
return $return;