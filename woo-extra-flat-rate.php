<?php
/**
 * @link              http://www.multidots.com/
 * @since             1.0.0
 * @package           Woo_Extra_Flat_Rate
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Extra Flat Rate
 * Plugin URI:        http://www.multidots.com/
 * Description:       Woo Extra Flat Rate plugin is for add new flat rate option in your WooCommerce site. All Shipping option is display in Front side so User can choose shipping method based on that.
 * Version:           1.0.0
 * Author:            Multidots
 * Author URI:        http://www.multidots.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-extra-flat-rate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-extra-flat-rate-activator.php
 */
function activate_woo_extra_flat_rate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-extra-flat-rate-activator.php';
	Woo_Extra_Flat_Rate_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-extra-flat-rate-deactivator.php
 */
function deactivate_woo_extra_flat_rate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-extra-flat-rate-deactivator.php';
	Woo_Extra_Flat_Rate_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_extra_flat_rate' );
register_deactivation_hook( __FILE__, 'deactivate_woo_extra_flat_rate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-extra-flat-rate.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_extra_flat_rate() {

	$plugin = new Woo_Extra_Flat_Rate();
	$plugin->run();

}
run_woo_extra_flat_rate();
