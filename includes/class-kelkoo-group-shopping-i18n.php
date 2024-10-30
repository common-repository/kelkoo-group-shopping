<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordpress.org/plugins/kelkoo-group-shopping
 * @since      1.0.0
 * @package    Kelkoo_Group_Shopping
 * @subpackage Kelkoo_Group_Shopping/includes
 * @author     Kelkoo group
 */
class Kelkoo_Group_Shopping_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'kelkoo-group-shopping',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
