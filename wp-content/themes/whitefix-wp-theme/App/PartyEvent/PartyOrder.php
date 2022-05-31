<?php

namespace App\PartyEvent;


use App\Helpers\Posts;
use App\Logger\Logger;
use WC_Order;
use WPCF7_ContactForm;
use WPCF7_Submission;

class PartyOrder
{

	public function __construct()
	{

		add_action('wpcf7_before_send_mail', [ $this, 'partyProcessCF7' ]);
		add_action( 'woocommerce_new_order', [ $this, 'partyProcess' ] );
//		add_action('woocommerce_checkout_order_processed', [ $this, 'partyProcess' ], 10, 1);


	}


//	/**
//	 * Create empty Party when order created.
//	 *
//	 * @param  $order_id
//	 *
//	 * @return void
//	 */

	/**
	 * If the cart contains a product from the "Party Events" category, create a new party event
	 *
	 * @param int order_id The order ID.
	 */
	public function partyProcess( int $order_id )
	{

		$order = new WC_Order($order_id);

		foreach (  WC()->session->get('cart') as $item )
		{

			if ( has_term('party-events', 'product_cat', $item['product_id']) )
			{
				( new PartyEvent() )->createParty($order);
				break;
			}

		}


		// TODO: send emails


	}


	/**
	 * Not used.
	 *
	 * @param $WPCF7_ContactForm
	 *
	 * @return void
	 */
	public function partyProcessCF7( $WPCF7_ContactForm )
	{

		if ( !is_plugin_active('contact-form-7/wp-contact-form-7.php') )
		{
			return;
		}

		$neededForm = Posts::getAcfValue('cf7_party_form');
		if ( isset($neededForm) && !empty($neededForm) )
		{

			$currentFormInstance = WPCF7_ContactForm::get_current();
			$contactFormSubmit = WPCF7_Submission::get_instance();
			if ( $contactFormSubmit )
			{
				$posted_data = $contactFormSubmit->get_posted_data();
			}

			if ( $neededForm->ID === $currentFormInstance->id() )
			{
				$partyEvent = ( new PartyEvent() )->createParty();
				( new Logger() )->run( 'New Party Event ID: ' . $partyEvent, 'party-log.log');
			}

		}


	}

}



