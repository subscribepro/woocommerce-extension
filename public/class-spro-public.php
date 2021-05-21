<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.subscribepro.com/
 * @since      1.0.0
 *
 * @package    Spro
 * @subpackage Spro/public
 */

use GuzzleHttp\Client;

class Spro_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var String $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add the endpoint for the subscriptions tab in WooCommerce My Account
	 *
	 * @since 1.0.0
	 */
	public function spro_add_endpoints() {

		add_rewrite_endpoint('subscriptions', EP_ROOT | EP_PAGES);
	
	}

	/**
	 * Add the subscriptions tab in WooCommerce My Account
	 *
	 * @since  1.0.0
	 * @param Array $items tab items.
	 */
	public function spro_subscriptions_tab( $items ) {

		$logout = $items['customer-logout'];
		unset($items['customer-logout']);
		$items['subscriptions'] = __( 'Subscriptions', 'spro' );
		$items['customer-logout'] = $logout;
		return $items;
	
	}

	/**
	 * Render the subscriptions tab content
	 *
	 * @since 1.0.0
	 */
	public function spro_render_subscriptions_tab() {
		?>
	
		<h2>Your Subscriptions</h2>
	
		<div class="content">
			<!-- My Subscriptions Widget div goes in main body of page -->
			<div id="sp-my-subscriptions"></div>
		</div>
	
		<!-- Load the Subscribe Pro widget script -->
		<script
			type="text/javascript"
			src="https://hosted.subscribepro.com/my-subscriptions/widget-my-subscriptions-1.2.5.js"
		></script>
	
		<?php
	
		$user_id = get_current_user_id();
		$spro_customer_id = get_the_author_meta( 'spro_id', $user_id );
		$username = "3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4";
		$password = "64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4";
		$host = 'https://api.subscribepro.com/oauth/v2/token';
	
		$data = array(
			'grant_type' => 'client_credentials',
			'scope' => 'widget',
			'customer_id' => $spro_customer_id
		);
	
		$ch = curl_init($host);    
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$return = json_decode( curl_exec($ch) );
		
		?>
	
		<!-- Pass configuration and init the Subscribe Pro widget -->
		<script type="text/javascript">
			// Setup config for Subscribe Pro
			var widgetConfig = {
				apiBaseUrl: 'https://api.subscribepro.com',
				apiAccessToken: '<?php echo $return->access_token; ?>',
				environmentKey: '<?php echo $return->environment_key; ?>',
				customerId: '<?php echo $spro_customer_id; ?>',
				themeName: 'base',
			};
			// Call widget init()
			window.MySubscriptions.init(widgetConfig);
		</script>
	
		<?php
	}

	/**
	 * Add the Subscribe Pro options to the single product page
	 *
	 * @since 1.0.0
	 */
	public function spro_before_add_to_cart_btn() {

		global $product;

		$is_spro = get_post_meta( $product->get_id(), '_spro_product', true );

		if ( $is_spro == 'yes' ) {

			$response_body = $this->spro_get_product( $product->get_sku() );

			$intervals = $response_body[0]->intervals;
			$price = $response_body[0]->price;
			$isDiscountPercentage = $response_body[0]->isDiscountPercentage;
			$discount = $response_body[0]->discount;

			if ( $isDiscountPercentage == true ) {
				$discount = round((float)$discount * 100 ) . '%';
			} else {
				$discount = '$' . number_format( $discount, 2, '.', ',' );
			}
	
			$product_data = array(
				'intervals' => $intervals,
				'price' => number_format( $price, 2, '.', ',' ),
				'isDiscountPercentage' => $isDiscountPercentage,
				'discount' => $discount
			);
	
			$templates = new Spro_Template_Loader;
	
			ob_start();
	
			$templates->set_template_data( $product_data, 'product_data' );
			$templates->get_template_part( 'woocommerce/content', 'options' );
	
			echo ob_get_clean();

		}

	}

	/**
	 * Validate the Subscribe Pro options on the single product page
	 * 
	 * @since 1.0.0
	 * @param Array $passed Validation status.
	 * @param Integer $product_id Product ID.
	 * @param Boolean $quantity Quantity
	 */
	public function spro_validate_custom_field( $passed, $product_id, $quantity ) {

		if( empty( $_POST['delivery_type'] ) ) {
			// Fails validation
			$passed = false;
			wc_add_notice( __( 'Please select a delivery type', 'spro' ), 'error' );
		}

		if( empty( $_POST['delivery_frequency'] ) ) {
			// Fails validation
			$passed = false;
			wc_add_notice( __( 'Please select a delivery frequency', 'spro' ), 'error' );
		}

		return $passed;
	}

	/**
	 * Add the custom field data to the cart
	 * @since 1.0.0
	 * @param Array $cart_item_data Cart item meta data.
	 * @param Integer $product_id Product ID.
	 * @param Integer $variation_id Variation ID.
	 * @param Boolean $quantity Quantity
	 */
	public function spro_add_custom_field_item_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
		
		if( ! empty( $_POST['delivery_type'] ) ) {
			// Add the item data
			$cart_item_data['delivery_type'] = $_POST['delivery_type'];
		}
		
		if( ! empty( $_POST['delivery_frequency'] ) ) {
			// Add the item data
			$cart_item_data['delivery_frequency'] = $_POST['delivery_frequency'];
		}

		return $cart_item_data;

	}

	/**
	 * Display the custom field value in the cart
	 * 
	 * @since 1.0.0
	 */
	public function spro_cart_item_name( $name, $cart_item, $cart_item_key ) {
		
		if( isset( $cart_item['delivery_type'] ) ) {
			$name .= sprintf(
			'<br><strong>Delivery Type</strong>: %s<br>',
			esc_html( $cart_item['delivery_type'] )
			);
		}

		if( isset( $cart_item['delivery_frequency'] ) ) {
			$name .= sprintf(
			'<strong>Delivery Frequency</strong>: %s<br>',
			esc_html( $cart_item['delivery_frequency'] )
			);
		}

		return $name;

	}

	/**
	 * Add custom field to order object
	 * 
	 * @since 1.0.0
	 */
	public function spro_add_custom_data_to_order( $item, $cart_item_key, $values, $order ) {

		foreach( $item as $cart_item_key=>$values ) {
			if( isset( $values['delivery_type'] ) ) {
				$item->add_meta_data( __( 'Delivery Type', 'spro' ), $values['delivery_type'], true );
			}

			if( isset( $values['delivery_frequency'] ) ) {
				$item->add_meta_data( __( 'Delivery Frequency', 'spro' ), $values['delivery_frequency'], true );
			}
		}

	}

	/**
	 * Retrieves Access Token
	 * 
	 * @since 1.0.0
	 */
	public function spro_get_access_token() {

		if ( false === ( $value = get_transient( 'spro_access_token' ) ) ) {
			
			$client = new Client();
			$user_id = get_current_user_id();
			$spro_customer_id = get_the_author_meta( 'spro_id', $user_id );

			$data = array(
				'grant_type' => 'client_credentials',
				'scope' => 'widget',
				'customer_id' => $spro_customer_id
			);

			$response = $client->request(
				'GET',
				'https://api.subscribepro.com/oauth/v2/token',
				[
				'auth' => ['3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4', '64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4'],
				'verify' => false,
				'query' => http_build_query($data)
				]
			);

			$access_token = json_decode( $response->getBody() )->access_token;
	
			set_transient( 'spro_access_token', $access_token, HOUR_IN_SECONDS );

		}

		return get_transient( 'spro_access_token' );

	}
	
	/**
	 * Retrieves Product Data
	 * 
	 * @since 1.0.0
	 */
	public function spro_get_product( $sku ) {
		
		if ( false === ( $value = get_transient( $sku . '_spro_product' ) ) ) {
			
			$client = new Client();
			$access_token = $this->spro_get_access_token();

			$data = array(
				'access_token' => $access_token,
				'sku' => $sku,
			);
	
			$response = $client->request(
				'GET',
				'https://api.subscribepro.com/products',
				[
				'auth' => ['3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4', '64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4'],
				'verify' => false,
				'query' => http_build_query( $data )
				]
			);
	
			$response_body = json_decode( $response->getBody() );

			set_transient( $sku . '_spro_product', $response_body, 24 * HOUR_IN_SECONDS );

		}

		return get_transient( $sku . '_spro_product' );

	}

	/**
	 * WooCommerce Payment Complete Hook
	 * 
	 * @since 1.0.0
	 * @param Integer $order_id Order ID.
	 */
	public function spro_payment_complete( $order_id ) {

		// Get Order Info
		$order = wc_get_order( $order_id );
		$customer_id = get_current_user_id();
		$spro_customer_id = get_user_meta( $customer_id, 'spro_id', true );
		$is_spro_customer = $spro_customer_id != '' ? true : false;
		$payment_token = get_post_meta( $order_id, '_wc_authorize_net_cim_credit_card_payment_token', true );
		$client = new Client();
		$access_token = $this->spro_get_access_token();
		$cc_last4 = get_post_meta( $order_id, '_wc_authorize_net_cim_credit_card_account_four', true );
		$cc_expiry = get_post_meta( $order_id, '_wc_authorize_net_cim_credit_card_card_expiry_date', true );
		$cc_month = substr( $cc_expiry, 3, 5 );
		$cc_year = substr( $cc_expiry, 0, 2 );
		$shipping_method = $order->get_shipping_method();

		// Customer Billing Address
		$billing_address = array(
			'first_name' => $order->get_billing_first_name(),
			'last_name' => $order->get_billing_last_name(),
			'street1' => $order->get_billing_address_1(),
			'street2' => $order->get_billing_address_2(),
			'city' => $order->get_billing_city(),
			'region' => $order->get_billing_state(),
			'zip' => $order->get_billing_postcode(),
			'country' => $order->get_billing_country()
		);

		// Customer Shipping Address
		$shipping_address = array(
			'first_name' => $order->get_shipping_first_name(),
			'last_name' => $order->get_shipping_last_name(),
			'street1' => $order->get_shipping_address_1(),
			'street2' => $order->get_shipping_address_2(),
			'city' => $order->get_shipping_city(),
			'region' => $order->get_shipping_state(),
			'zip' => $order->get_shipping_postcode(),
			'country' => $order->get_shipping_country()
		);

		// Create the customer in Subscribe Pro if needed
		// if ( !$is_spro_customer ) {

		// 	$response = $client->post('https://api.subscribepro.com/services/v2/customer.json', [
		// 		'verify' => false,
		// 		'auth' => ['3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4', '64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4'],
		// 		'json' => ['customer' => 
		// 			array(
		// 				'platform_specific_customer_id' => $customer_id,
		// 				'first_name' => $billing_address['first_name'],
		// 				'last_name' => $billing_address['last_name'],
		// 				'email' => $order->get_billing_email()
		// 			)
		// 		]
		// 	]);
			
		// 	$response_body = json_decode( $response->getBody() );

		// 	// Update WooCommerce customer with subscribe pro id
		// 	$spro_customer_id = $response_body->customer->id;
		// 	update_user_meta( $customer_id, 'spro_id', $spro_customer_id );

		// 	echo '<pre>';
		// 	print_r( $response_body );
		// 	echo '</pre>';

		// }

		// echo '<pre>';
		// print_r( $order );
		// echo '</pre>';

		// Create new payment profile
		// $response = $client->post('https://api.subscribepro.com/services/v2/vault/paymentprofile/external-vault.json', [
		// 	'verify' => false,
		// 	'auth' => ['3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4', '64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4'],
		// 	'json' => ['payment_profile' =>
		// 		array(
		// 			'customer_id' => $spro_customer_id,
		// 			'payment_token' => $payment_token, //1931554041|1843624109
		// 			'creditcard_last_digits' => $cc_last4,
		// 			'creditcard_month' => $cc_month,
		// 			'creditcard_year' => $cc_year,
		// 			'billing_address' => $billing_address
		// 		)
		// 	]
		// ]);

		// $response_body = json_decode( $response->getBody() );

		// echo '<pre>';
		// print_r( $response_body );
		// echo '</pre>';

		foreach( $order->get_items() as $item_id => $line_item ) {

			$item_data = $line_item->get_data();
			$product = $line_item->get_product();
			$sku = $product->get_sku();
			$product_name = $product->get_name();
			$item_quantity = $line_item->get_quantity();
			$item_total = $line_item->get_total();

			$is_subscription_product = get_post_meta( $product->get_id(), '_spro_product', true );

			if ( $is_subscription_product == 'yes' ) {

				$frequency = wc_get_order_item_meta( $item_id, 'Delivery Frequency', true );
				
				$response = $client->post('https://api.subscribepro.com/services/v2/subscription.json', [
					'verify' => false,
					'auth' => ['3945_luvt7zqsg9ccg00sg8oow8w8sokc8kwgw4cogsgwwcc0g0ks4', '64id8uxlw9wkgogw00wwss4s0w848ksc4c0480swcs4c0ksko4'],
					'json' => ['subscription' => 
						array(
							'customer_id' => $spro_customer_id,
							'payment_profile_id' => '6292857',
							'product_sku' => $sku,
							'requires_shipping' => true,
							'shipping_method_code' => $shipping_method,
							'shipping_address' => $shipping_address,
							'qty' => $item_quantity,
							'next_order_date' => date("F j, Y"),
							'first_order_already_created' => true,
							'interval' => $frequency
						)
					]
				]);
				
				$response_body = json_decode( $response->getBody() );
	
				echo '<pre>';
				print_r( $response_body );
				echo '</pre>';

			}

		}

	}


}