<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/reanderagulto
 * @since      1.0.0
 *
 * @package    Pv_Intakte_Form_Rotator
 * @subpackage Pv_Intakte_Form_Rotator/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pv_Intakte_Form_Rotator
 * @subpackage Pv_Intakte_Form_Rotator/includes
 * @author     Reander Agulto <reanderagulto29@gmail.com>
 */
class Pv_Intakte_Form_Rotator_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pv-intakte-form-rotator',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
