<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class Woo_Extra_Flat_Rate_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . "woocommerce_extra_flat_rates";
		$sql = "DROP TABLE $table_name;";	
	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$wpdb->query( $sql );
	}

}
