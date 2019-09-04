<?php
require_once(plugin_dir_path( __FILE__ ).'../data/display_model.php'); 
$array = array();
$get = new display_model();
$intakes = $get->show_all_intake_by_status(1);
$return = '<div class="owl-carousel owl-theme">';
while($row = $intakes->fetch_assoc()){
    $return .= '<div class="item">
        <div class="intake-slider-item">
            <b>From:</b> ' . $row['name_from'] . ' <br>
            <b>To:</b> ' . $row['name_to'] . ' <br>
            <b>Message:</b><br>
            <p>' . $row['intake_message'] . '</p>
        </div>
    </div>';
}
$return .= '</div>';
return $return;