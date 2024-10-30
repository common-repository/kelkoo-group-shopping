<?php

/**
 * The Kelkoo Group Shopping plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/kelkoo-group-shopping
 * @since             1.0.0
 * @package           Kelkoo_Group_Shopping
 *
 * @wordpress-plugin
 * Plugin Name:       Kelkoo Group Shopping
 * Plugin URI:        https://wordpress.org/plugins/kelkoo-group-shopping
 * Description:       Plugin to monetize your web site or blog with Kelkoo group affiliation program
 * Version:           1.2
 * Author:            Kelkoo Group
 * Author URI:        https://www.kelkoogroup.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kelkoo-group-shopping
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kelkoo-group-shopping-activator.php
 */
function activate_Kelkoo_Group_Shopping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kelkoo-group-shopping-activator.php';
	Kelkoo_Group_Shopping_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kelkoo-group-shopping-deactivator.php
 */
function deactivate_Kelkoo_Group_Shopping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kelkoo-group-shopping-deactivator.php';
	Kelkoo_Group_Shopping_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Kelkoo_Group_Shopping' );
register_deactivation_hook( __FILE__, 'deactivate_Kelkoo_Group_Shopping' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kelkoo-group-shopping.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Kelkoo_Group_Shopping() {

	$plugin = new Kelkoo_Group_Shopping();
	$plugin->run();

}
run_Kelkoo_Group_Shopping();
