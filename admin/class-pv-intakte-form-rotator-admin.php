<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/reanderagulto
 * @since      1.0.0
 *
 * @package    Pv_Intakte_Form_Rotator
 * @subpackage Pv_Intakte_Form_Rotator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pv_Intakte_Form_Rotator
 * @subpackage Pv_Intakte_Form_Rotator/admin
 * @author     Reander Agulto <reanderagulto29@gmail.com>
 */
class Pv_Intakte_Form_Rotator_Admin {
	function pv_register_css(){
		wp_enqueue_style('pv-intake-datatable-css','//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css');
		wp_enqueue_style('pv-intake-font-awesomeG', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css');
		wp_enqueue_style('pvcss',''.plugins_url('css/pv-intake-admin.css',__FILE__ ).'');
	}
	function pv_register_front_css(){
		wp_enqueue_style('pv-intake-frontcss',''.plugins_url('css/pv-intake.css',__FILE__ ).'');
		wp_enqueue_style('pv-intake-pagination',''.plugins_url('css/pagination.css',__FILE__ ).'');
		wp_enqueue_style('pv-intake-fa','//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css');
		wp_enqueue_style('pv-intake-owl-theme','//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css');
	}
	function pv_register_js(){
		wp_enqueue_script( 'pv-datatable-js', '//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js' );
		wp_enqueue_script( 'pvjs', ''.plugins_url('js/pv-intake-admin.js',__FILE__ ).'' );
	}	
	function pv_register_front_js(){
		//JQUERY
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'pv-owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js' );
		
		wp_enqueue_script( 'pv-pagination-js', ''.plugins_url('js/pagination.js',__FILE__ ).'' );
		wp_enqueue_script( 'pv-intake-script-js', ''.plugins_url('js/pv-intake-script.js',__FILE__ ).'' );
	}	

}
