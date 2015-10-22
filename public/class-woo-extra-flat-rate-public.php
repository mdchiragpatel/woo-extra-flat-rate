<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/public
 * @author     Multidots <wordpress@multidots.com>
 */
class Woo_Extra_Flat_Rate_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Extra_Flat_Rate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Extra_Flat_Rate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-extra-flat-rate-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Extra_Flat_Rate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Extra_Flat_Rate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-extra-flat-rate-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * WooCommerce Add Extra Shipping Method
	 * --------------------------
	 *
	 * Add Extra shipping method
	 *
	 */
	function add_another_custom_flat_rate( $method, $rate ) {
		global $wpdb;
		$rates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_extra_flat_rates" );
		
		$flat_rate_array = array();
		foreach ( $rates as $rate_key => $extra_rate ) {
			$flat_rate_array[$rate_key]['lable'] = $extra_rate->extra_flat_rate_name;
			$flat_rate_array[$rate_key]['cost'] = $extra_rate->extra_flat_rate;
		}
		
		$flat_count = 1;
		foreach ( $flat_rate_array as $flat_rate_value ) {
			$new_rate         = $rate;
			$new_rate['id']    .= ':' . "custom_flat_rate_$flat_count";
			$new_rate['label'] = $flat_rate_value['lable'];
			$new_rate['cost']  = $flat_rate_value['cost'];
			
			$method->add_rate( $new_rate );
			$flat_count++;
		}
	}
	
	
	/**
	 * BN code added 
	 */
	function paypal_bn_code_filter($paypal_args) {
		$paypal_args['bn'] = 'Multidots_SP';
		return $paypal_args;
	}

}
