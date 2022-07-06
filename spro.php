<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.subscribepro.com/
 * @since             1.0.0
 * @package           Spro
 *
 * @wordpress-plugin
 * Plugin Name:       Subscribe Pro
 * Plugin URI:        https://www.subscribepro.com/
 * Description:       A plugin for connecting Subscribe Pro to WooCommerce.
 * Version:           1.0.0
 * Author:            Brady Christopher
 * Author URI:        https://www.subscribepro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       spro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPRO_VERSION', '1.0.0' );

/**
 * Define plugin directory constant
 */
define( 'SPRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Define plugin settings constant
 */
define( 'SPRO_BASE_URL', get_option( 'spro_settings_base_url' ) );
define( 'SPRO_CLIENT_ID', get_option( 'spro_settings_client_id' ) );
define( 'SPRO_CLIENT_SECRET', get_option( 'spro_settings_client_secret' ) );
define( 'SP_HMAC_HEADER', 'sp_hmac' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spro-activator.php
 */
function activate_spro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spro-activator.php';
	Spro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spro-deactivator.php
 */
function deactivate_spro() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-spro-deactivator.php';
	Spro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_spro' );
register_deactivation_hook( __FILE__, 'deactivate_spro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-spro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spro() {

	$plugin = new Spro();
	$plugin->run();

}
run_spro();

/**
 * Filter the cart template path to use our cart.php template instead of the theme's
 */
function sp_locate_template( $template, $template_name, $template_path ) {
	
	$basename = basename( $template );
	
	if( $basename == 'cart.php' ) {
		$template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates/woocommerce/cart/cart.php';
	}

	return $template;

}
add_filter( 'woocommerce_locate_template', 'sp_locate_template', 10, 3 );