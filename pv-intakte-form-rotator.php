<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/reanderagulto
 * @since             1.0.0
 * @package           Pv_Intakte_Form_Rotator
 *
 * @wordpress-plugin
 * Plugin Name:       PV Intake Form Rotator
 * Plugin URI:        https://github.com/reanderagulto/pv-intake-form-rotator
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Reander Agulto
 * Author URI:        https://github.com/reanderagulto
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pv-intakte-form-rotator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pv-intakte-form-rotator-activator.php
 */
function activate_pv_intakte_form_rotator() {
	require_once plugin_dir_path( __FILE__ ) . 'jpc/data/database_model.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-primeview-plugin-activator.php';
	
	Primeview_Plugin_Activator::activate();
	
	$db = new database_model();
	$db->create_tables();		
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pv-intakte-form-rotator-deactivator.php
 */
function deactivate_pv_intakte_form_rotator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pv-intakte-form-rotator-deactivator.php';
	Pv_Intakte_Form_Rotator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pv_intakte_form_rotator' );
register_deactivation_hook( __FILE__, 'deactivate_pv_intakte_form_rotator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pv-intakte-form-rotator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pv_intakte_form_rotator() {

	require_once plugin_dir_path( __FILE__ ) . 'admin/class-pv-intakte-form-rotator-admin.php'; //Require Admin class
	require_once plugin_dir_path( __FILE__ ) . 'jpc/create-page.php'; 							//Create Admin Pages
	 
	$assets = new Pv_Intakte_Form_Rotator_Admin(); 												//Init Class
	
	if(is_admin()){
		$assets->pv_register_css();																//Load CSS
		$assets->pv_register_js();																//Load JS																
	}else{
		$assets->pv_register_front_css();	
		$assets->pv_register_front_js();	
	}

}
run_pv_intakte_form_rotator();
