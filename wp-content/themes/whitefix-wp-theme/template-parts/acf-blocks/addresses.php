<?php

use App\Helpers\Posts;


$addressesRepeater = Posts::getAcfSubValue('address_repeater');
$emailsRepeater = Posts::getAcfSubValue('emails_repeater');
$phonesRepeater = Posts::getAcfSubValue('phones_repeater');

$socialNetworks = Posts::getAcfSubValue('social_networks');
?>

<div class="light-bg py-5"
     id="<?= Posts::getAcfSubValue('anchor') ?>">

	<div class="container">
		<div class="row">


			<div class="col-lg-6 text-center text-lg-left">


				<?php if ( isset($addressesRepeater) && !empty($addressesRepeater) ) : ?>
					<div class="d-flex flex-column align-items-start justify-content-center text-left mb-3 ">
						<?php foreach ( $addressesRepeater as $address ) : ?>
							<p class="mb-2">
								<span class="ti-location-pin mr-2"></span>
								<?= $address['address'] ?>
							</p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>


				<?php if ( isset($emailsRepeater) && !empty($emailsRepeater) ) : ?>
					<div class="d-flex flex-column align-items-start justify-content-center text-left mb-3">
						<?php foreach ( $emailsRepeater as $email ) : ?>
							<p class="mb-2">
								<span class="ti-email mr-2"></span>
								<a class="mr-4"
								   href="mailto:<?= $email['email'] ?>">
									<?= $email['email'] ?>
								</a>
							</p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>


				<?php if ( isset($phonesRepeater) && !empty($phonesRepeater) ) : ?>
					<div class="d-flex flex-column align-items-start justify-content-center text-left mb-3">
						<?php foreach ( $phonesRepeater as $phone ) : ?>
							<p class="mb-2">
								<span class="ti-headphone-alt mr-2"></span>
								<a href="tel:<?= tel_href($phone['phone']) ?>">
									<?= $phone['phone'] ?>
								</a>
							</p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>


			<div class="col-lg-6">

				<?php if ( isset($socialNetworks) && !empty($socialNetworks) ) : ?>
					<div class="social-icons">
						<?php foreach ( $socialNetworks as $key => $social ) : ?>

							<?php
							if ( isset($social) && !empty($social) )
							{
								$iconClass = '';
								switch ( $key )
								{
									case 'facebook':
										$iconClass = 'ti-facebook';
									break;
									case 'instagram':
										$iconClass = 'ti-instagram';
									break;
									case 'youtube':
										$iconClass = 'ti-youtube';
									break;
									case 'vimeo':
										$iconClass = 'ti-vimeo';
									break;
									case 'linkedin':
										$iconClass = 'ti-linkedin';
									break;
									case 'pinterest':
										$iconClass = 'ti-pinterest';
									break;
								}
								?>
								<a href="<?= $social ?>" target="_blank">
									<span class="<?= $iconClass ?>"></span>
								</a>
								<?php
							}
							?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>


		</div>

	</div>

</div>
