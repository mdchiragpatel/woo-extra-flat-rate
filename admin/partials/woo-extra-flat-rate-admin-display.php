<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WC_Settings_Extra_Shipping_Methods {
	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Class hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		// Add WC settings tab
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'settings_tab' ), 60 );

		// Settings page contents
		add_action( 'woocommerce_settings_tabs_shipping_methods', array( $this, 'settings_page' ) );

		// Save settings page
		add_action( 'woocommerce_update_options_shipping_methods', array( $this, 'update_options' ) );
	}

	/**
	 * Settings tab.
	 *
	 * Add a WooCommerce settings tab for the Receiptful settings page.
	 *
	 * @since 1.0.0
	 *
	 * @param 	array	$tabs 	Array of default tabs used in WC.
	 * @return 	array 			All WC settings tabs including newly added.
	 */
	public function settings_tab( $tabs ) {

		$tabs['shipping_methods'] = __( 'Extra Flat Rate', 'woocommerce-extra-flat-rate' );

		return $tabs;

	}

	/**
	 * Settings page content.
	 *
	 * @since 1.0.0
	 */
	public function settings_page() { 
		global $wpdb;
		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}
		?>
		<h3><?php printf( __( 'Extra Flat Rates', 'woocommerce' ) ); ?></h3>
		<table class="wc_extra_flat_rates wc_input_table sortable widefat">
			<thead>
				<tr>
					<th width="4%" class="sort">&nbsp;</th>
					<th width="48%"><?php _e( 'Flat&nbsp;Rate&nbsp;Name', 'woocommerce' ); ?>&nbsp;<span class="tips" data-tip="<?php esc_attr_e('Enter a name for this flat rate.', 'woocommerce'); ?>">[?]</span></th>
					<th width="48%"><?php _e( 'Rate&nbsp;', 'woocommerce' ); ?>&nbsp;<span class="tips" data-tip="<?php esc_attr_e( 'Enter a flat rate value.', 'woocommerce' ); ?>">[?]</span></th>
				</tr>
			</thead>
			<tbody id="rates">
			<?php
				$rates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}woocommerce_extra_flat_rates");
				if ( !empty($rates) && isset($rates) ) { 
				
					foreach ( $rates as $rate ) {
						?>
						<tr class="tips" data-tip="<?php echo __( 'Flat rate ID', 'woocommerce' ) ?>">
							<td width="4%" class="sort"><input type="hidden" class="remove_flat_rate" name="remove_flat_rate[<?php echo $rate->extra_flat_rate_id; ?>]" value="0" /></td>
							<td class="name" width="48%">
								<input type="text" value="<?php echo $rate->extra_flat_rate_name; ?>" name="extra_flat_rate_name[<?php echo $rate->extra_flat_rate_id; ?>]" />
							</td>
							
							<td class="rate" width="48%">
								<input type="number" step="any" min="0" value="<?php echo $rate->extra_flat_rate; ?>" placeholder="0" name="extra_flat_rate[<?php echo $rate->extra_flat_rate_id ?>]" />
							</td>
						</tr>
						<?php
					}
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="10">
						<a href="#" class="button plus insert"><?php _e( 'Insert row', 'woocommerce' ); ?></a>
						<a href="#" class="button minus remove_tax_rates"><?php _e( 'Remove selected row(s)', 'woocommerce' ); ?></a>
					</th>
				</tr>
			</tfoot>
		</table>
	<?php
	}

	/**
	 * Save settings.
	 *
	 * Save settings based on WooCommerce save_fields() method.
	 *
	 * @since 1.0.0
	 */
	public function update_options() {
		global $woocommerce,$post,$wpdb;
		
		if ( ! empty( $_POST['extra_flat_rate_name'] ) ) {
			$this->save_extra_flat_rates();
		}
	}
		
	/**
	 * Save Extra Flat rates.
	 *
	 * @since 1.0.0
	 */
	public function save_extra_flat_rates() {
		global $wpdb;

		// get the tax rate id of the first submited row
		$first_extra_flat_rate_id = key( $_POST['extra_flat_rate_name'] );

		// Loop posted fields
		foreach ( $_POST['extra_flat_rate_name'] as $key => $value ) {
			$mode        = 0 === strpos( $key, 'new-' ) ? 'insert' : 'update';
			$extra_flat_rate    = $this->get_posted_extra_rate( $key );

			if ( 'insert' === $mode ) {
				$extra_flat_rate_id = WC_Settings_Extra_Shipping_Methods::_insert_extra_flat_rate( $extra_flat_rate );
			} elseif ( 1 == $_POST['remove_flat_rate'][ $key ] ) {
				$extra_flat_rate_id = absint( $key );
				WC_Settings_Extra_Shipping_Methods::_delete_extra_flat_rate( $extra_flat_rate_id );
				continue;
			} else {
				$extra_flat_rate_id = absint( $key );
				WC_Settings_Extra_Shipping_Methods::_update_extra_flat_rate( $extra_flat_rate_id, $extra_flat_rate );
			}
		}
	}
	
	/**
	 * get Extra flat rate array
	 *
	 * @since 1.0.0
	 */
	public function get_posted_extra_rate( $key ) {
		$extra_flat_rate     = array();
		$extra_flat_rate_keys = array(
			'extra_flat_rate_name',
			'extra_flat_rate'
		);

		foreach ( $extra_flat_rate_keys as $extra_flat_rate_key ) {
			if ( isset( $_POST[ $extra_flat_rate_key ] ) && isset( $_POST[ $extra_flat_rate_key ][ $key ] ) ) {
				$extra_flat_rate[ $extra_flat_rate_key ] = wc_clean( $_POST[ $extra_flat_rate_key ][ $key ] );
			}
		}
		return $extra_flat_rate;
	}
	
	/**
	 * prepare Extra flat rate
	 *
	 * @since 1.0.0
	 */
	private static function prepare_extra_flat_rate( $extra_flat_rate ) {
		foreach ( $extra_flat_rate as $key => $value ) {
			if ( method_exists( __CLASS__, 'format_' . $key ) ) {
				$extra_flat_rate[ $key ] = call_user_func( array( __CLASS__, 'format_' . $key ), $value );
			}
		}
		return $extra_flat_rate;
	}
	
	/**
	 * insert Extra flat rate
	 *
	 * @since 1.0.0
	 */
	public static function _insert_extra_flat_rate( $extra_flat_rate ) {
		global $wpdb;

		$wpdb->insert( $wpdb->prefix . 'woocommerce_extra_flat_rates', self::prepare_extra_flat_rate( $extra_flat_rate ) );
		return $wpdb->insert_id;
	}
	
	/**
	 * delete Extra flat rate
	 *
	 * @since 1.0.0
	 */
	public static function _delete_extra_flat_rate( $extra_flat_rate_id ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}woocommerce_extra_flat_rates WHERE extra_flat_rate_id = %d;", $extra_flat_rate_id ) );
	}
	
	/**
	 * update Extra flat rate
	 *
	 * @since 1.0.0
	 */
	public static function _update_extra_flat_rate( $extra_flat_rate_id, $extra_flat_rate ) {
		global $wpdb;

		$extra_flat_rate_id = absint( $extra_flat_rate_id );

		$wpdb->update(
			$wpdb->prefix . "woocommerce_extra_flat_rates",
			self::prepare_extra_flat_rate( $extra_flat_rate ),
			array(
				'extra_flat_rate_id' => $extra_flat_rate_id
			)
		);
	}
}