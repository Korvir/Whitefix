<?php

use App\Helpers\Posts;

?>


<div class="section bg-gradient lozad"
     id="<?= Posts::getAcfSubValue('anchor') ?>"
     data-background-image="<?= Posts::getAcfSubValue('bg_image')['url'] ?>" >

	<div class="container">
		<div class="row">
			<div class="col-12">

				<div class="call-to-action d-flex flex-column align-items-center justify-content-center">

					<div class="box-icon">
						<span class="ti-headphone-alt gradient-fill ti-3x"></span>
					</div>

					<h2><?= Posts::getAcfSubValue('title') ?></h2>

					<p class="tagline">
						<?= Posts::getAcfSubValue('subtitle') ?>
					</p>

					<div class="my-4">
						<button type="button" class="btn btn-light text-dark contact-button">
							<?= Posts::getAcfSubValue('button_text') ?>
						</button>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>
