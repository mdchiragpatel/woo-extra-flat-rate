<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class Woo_Extra_Flat_Rate_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb,$woocommerce;
		
		
		if( !in_array( 'woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins'))) && !is_plugin_active_for_network( 'woocommerce/woocommerce.php' )   ) { 
			wp_die( "<strong>WooCommerce Extra Flat Rate</strong> Plugin requires <strong>WooCommerce</strong> <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
		} elseif ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, '2.4.0', '<' ) ){
			wp_die( "<strong>WooCommerce Extra Flat Rate/strong> Plugin requires <strong>WooCommerce</strong> version greater then or equal to 2.4.0" );
		} else {
			$table_name = $wpdb->prefix . "woocommerce_extra_flat_rates";
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			$sql = "CREATE TABLE $table_name (
					extra_flat_rate_id bigint(20) NOT NULL auto_increment,
					extra_flat_rate_name varchar(200) NOT NULL DEFAULT '',
					extra_flat_rate varchar(200) NOT NULL DEFAULT '',
					PRIMARY KEY  (extra_flat_rate_id)
			   		);";	
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			}
		}
	}

}
