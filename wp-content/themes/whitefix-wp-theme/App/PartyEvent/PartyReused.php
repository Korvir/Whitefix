<?php

namespace App\PartyEvent;


use WC_Coupon;


class PartyReused
{

	public function __construct()
	{
		//
	}


	/**
	 * @param $emailGuest
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function generateCoupon( $emailGuest = null ): string
	{

		$coupon_code = bin2hex(random_bytes(4));
		$userEmail = wp_get_current_user()->user_email;

		$restrictedEmails = [];

		$restrictedEmails[] = $userEmail;
		if ( isset($emailGuest) )
		{
			$restrictedEmails[] = $emailGuest;
		}


		$coupon = new WC_Coupon();

		$coupon->set_code($coupon_code);

		$coupon->set_discount_type('percent');
		$coupon->set_amount(20);
		$coupon->set_date_expires(null);

		$coupon->set_usage_limit(1);
		$coupon->set_usage_limit_per_user(1);

//		$coupon->set_product_categories([]);

		$coupon->set_email_restrictions($restrictedEmails);

		//save the coupon
		$coupon->save();

		return $coupon;

	}

}
