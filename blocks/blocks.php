<?php

namespace SwissBitcoinPay\WC\Blocks;

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
use SwissBitcoinPay\Gateway\WC_Gateway_Swiss_Bitcoin_Pay;

/**
 * Swiss Bitcoin Pay Default Gateway Payments Blocks integration
 *
 * @since 2.4.0
 */
final class DefaultGatewayBlocks extends AbstractPaymentMethodType {

	/**
	 * The gateway instance.
	 */
	private $gateway;

	/**
	 * Payment method name/id/slug.
	 */
	protected $name = 'sbp';

	/**
	 * Initializes the payment method type.
	 */
	public function initialize(): void {
        $gateways       = \WC()->payment_gateways->payment_gateways();
        $this->gateway  = $gateways[ $this->name ];
	}

	/**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 */
	public function is_active(): bool {
		return $this->gateway->is_available();
	}

	/**
	 * Returns an array of scripts/handles to be registered for this payment method.
	 */
	public function get_payment_method_script_handles(): array {
		$script_path       = "blocks.js";
		$script_asset_path = plugin_dir_url(__FILE__) . "blocks.asset.php";
		$script_asset      = file_exists( $script_asset_path )
			? require( $script_asset_path )
			: array(
				'dependencies' => array(),
				'version'      => '1.2.0'
			);
		$script_url        = plugin_dir_url(__FILE__) . $script_path;

		wp_register_script(
			'sbp-gateway-blocks',
			$script_url,
			$script_asset[ 'dependencies' ],
			$script_asset[ 'version' ],
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'sbp-blocks-integration');
		}

		return [ 'sbp-gateway-blocks' ];
	}

	/**
	 * Returns an array of key=>value pairs of data made available to the payment methods script.
	 */
	public function get_payment_method_data(): array {
		return [
			'title' => $this->get_setting( 'title' ),
			'description' => $this->get_setting( 'description' ),
			'supports' => array_filter( $this->gateway->supports, [ $this->gateway, 'supports' ] )
		];
	}
}

?>