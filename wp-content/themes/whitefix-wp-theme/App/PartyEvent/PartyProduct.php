<?php

namespace App\PartyEvent;


class PartyProduct
{

	public function __construct()
	{

		// Remove quantity
		add_filter('woocommerce_is_sold_individually', [ $this, 'wc_remove_all_quantity_fields' ], 10, 2);

		//Add form
//		add_action('woocommerce_before_add_to_cart_button', [ $this, 'addAdditionalFields' ]);

		// Cart item-meta
//		add_filter('woocommerce_add_cart_item_data', [ $this, 'add_cart_item_data' ], 25, 2);
//		add_filter('woocommerce_get_item_data', [ $this, 'get_item_data' ], 25, 2);
//		add_action('woocommerce_new_order_item', [ $this, 'add_order_item_meta' ], 10, 3);

		add_filter('woocommerce_add_to_cart_validation', [ $this, 'filter_add_to_cart_validation' ], 10, 3);


	}



	public function addAdditionalFields()
	{
		global $product;
		if ( has_term('party-events', 'product_cat', $product->get_id()) )
		{
			get_template_part('App/PartyEvent/Views/party-form');
		}
	}


	public function add_cart_item_data( $cart_item_data, $product_id )
	{

		if ( has_term('party-events', 'product_cat', $product_id) )
		{
			$data = [];

			//		if ( isset($_POST['partyevent-date']) )
			//			$cart_item_data['custom_data']['partyevent-date'] = $data['partyevent-date'] = wp_strip_all_tags($_POST['partyevent-date']);

			foreach ( $_POST as $key => $value )
			{
				if ( $key === 'add-to-cart' )
					continue;

				if ( isset($value) && !empty($value) )
				{
					$cart_item_data['custom_data'][ $key ] = $data[ $key ] = wp_strip_all_tags($value);
				}
			}

			// Add the data to session and generate a unique ID
			if ( count($data) > 0 )
			{
				$cart_item_data['custom_data']['unique_key'] = md5(microtime() . rand());
				WC()->session->set('custom_data', $data);
			}
		}

		return $cart_item_data;

	}


	public function get_item_data( $cart_data, $cart_item )
	{


		if ( has_term('party-events', 'product_cat', $cart_item['product_id']) )
		{

			if ( !empty($cart_item['custom_data']) )
			{

				foreach ( $cart_item['custom_data'] as $key => $value )
				{

					if ( $key === 'unique_key' )
						continue;

					switch ( $key )
					{
						case 'partyevent-date':
							$name = 'Date';
						break;
						case 'partyevent-altdate':
							$name = 'Alternative Date';
						break;
						case 'partyevent-timeofparty':
							$name = 'Preferred time of Party';
						break;
						case 'partyevent-child-age':
							$name = 'Age of birthday Child';
						break;
						case 'partyevent-children-number':
							$name = 'Number of children';
						break;
						case 'partyevent-length':
							$name = 'Party Length';
						break;
						case 'party-options':
							$name = 'Options';
						break;
						case 'party-activity':
							$name = 'Activity';
						break;
						case 'party-extra':
							$name = 'Extra';
						break;
						case 'your-message':
							$name = 'Your message';
						break;
						case 'other-service':
							$name = 'Other services';
						break;

					}
					$cart_data[] = [
						'name' => __($name, "divi"),
						'display' => $value
					];

				}


			}

		}

		return $cart_data;
	}


	public function add_order_item_meta( $item_id, $cart_item, $cart_item_key )
	{
		if ( isset($cart_item['custom_data']) )
		{
			$values = [];
			foreach ( $cart_item['custom_data'] as $key => $value )
				if ( $key != 'unique_key' )
				{
					$values[] = $value;
				}
			$values = implode(', ', $values);
			wc_add_order_item_meta($item_id, __("Option", "aoim"), $values);
		}
	}


	public function wc_remove_all_quantity_fields()
	{
		return true;
	}


	/**
	 * @throws \Exception
	 */
	public function filter_add_to_cart_validation( $passed, $product_id, $quantity )
	{

		if ( !has_term('party-events', 'product_cat', $product_id) )
			return $passed;


		if ( !is_user_logged_in() )
		{
			$passed = false;
			wc_add_notice(__('Need to register account or login to buy this product', 'theme_domain'), 'error');
		}


		foreach ( WC()->cart->get_cart() as $key => $item )
		{

			if ( has_term('party-events', 'product_cat', $item['product_id']) )
			{
				$passed = false;
				wc_add_notice(__('Some Party Event already in cart.', 'theme_domain'), 'error');
				break;
			}

		}


		if ( (new PartyEvent())->getActiveParty() )
		{
			$passed = false;
			wc_add_notice(__('You can activate only one party.', 'theme_domain'), 'error');
		}

		return $passed;

	}


}
