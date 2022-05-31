<?php

namespace App\PartyEvent;


use App\Helpers\Posts;

class PartyMail
{

	public function __construct()
	{
		add_action('woocommerce_email_before_order_table', [ $this, 'addEmailText_1' ], 20, 4);
	}




	function addEmailText_1( $order, $sent_to_admin, $plain_text, $email )
	{

		$addToMail = false;
		foreach ( $order->get_items() as $item )
		{
			if ( has_term('party-events', 'product_cat', $item['product_id']) )
			{
				$addToMail = true;
			}
		}


		if ( $addToMail && $email->id == 'customer_processing_order' )
		{

			$userID = wp_get_current_user()->ID;
			$partyObj = (new PartyEvent())->getCurrentParty($userID, $order->get_id());
			$partyToken = array_shift( $partyObj );

			$emailText = Posts::getAcfValue('editor_mail_1');

			// {{token}}
			$emailText = str_replace("{{token}}", $partyToken->uuid, $emailText);

			echo '<br>';
			echo $emailText;

		}

	}


}
