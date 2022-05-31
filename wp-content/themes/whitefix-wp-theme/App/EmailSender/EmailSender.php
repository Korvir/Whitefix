<?php


namespace App\EmailSender;


use App\Helpers\Posts;

class EmailSender
{

	private string $subscribeEmailTo;
	private string $contactEmailTo;

	/**
	 * EmailSender constructor.
	 */
	public function __construct()
	{

		$this->contactEmailTo = Posts::getAcfValue('send_email_to');

		// Subscription form
		add_action('wp_ajax_contactForm', [ $this, 'contactForm_callback' ]);
		add_action('wp_ajax_nopriv_contactForm', [ $this, 'contactForm_callback' ]);
	}


	/**
	 * Contact Form Callback
	 *
	 * @return void
	 */
	public function contactForm_callback()
	{

		parse_str($_POST['form'], $formData);

		if ( !isset($formData['name'], $formData['phone']) )
		{
			wp_send_json_error(
				[
					'error' => __('All fields are required', 'wp-whitefix-theme'),
				]);
		}


		$headers = [
			'From: ' . wp_title() . ' <admin@whitefix.com>',
			'content-type: text/html',
		];
		$subject = 'New Contact Form!';
		$message = '<p>Ім`я: ' . $formData['name'] . '</p>
			<p>Телефон: ' . $formData['phone'] . '</p>';


		$mail = wp_mail($this->contactEmailTo, $subject, $message, $headers);

		if ( $mail )
		{
			wp_send_json_success(
				[
					'message' => 'Thank You!',
				]);
		}


		wp_send_json_error(
			[
				'error' => __('Вибачте, якась помилка!', 'wp-whitefix-theme'),
			]);
	}


}
