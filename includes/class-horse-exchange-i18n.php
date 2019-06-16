<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       Gambling Ninja
 * @since      1.0.0
 *
 * @package    Horse_Exchange
 * @subpackage Horse_Exchange/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Horse_Exchange
 * @subpackage Horse_Exchange/includes
 * @author     Gambling Ninja <support@gamblingninja.com>
 */
class Horse_Exchange_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'horse-exchange',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
