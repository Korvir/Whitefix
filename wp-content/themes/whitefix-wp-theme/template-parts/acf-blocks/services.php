<?php

use App\Helpers\Posts;

?>

<div class="section light-bg"
     id="<?= Posts::getAcfSubValue('anchor') ?>">


	<div class="container">

		<div class="section-title">
			<small> <?= Posts::getAcfSubValue('subtitle') ?> </small>
			<h3> <?= Posts::getAcfSubValue('title') ?> </h3>
		</div>


		<?php
		$servicesBlocks = Posts::getAcfSubValue('blocks');

		if ( isset($servicesBlocks) && !empty($servicesBlocks) ) : ?>
			<div class="row">
				<?php foreach ( $servicesBlocks as $servicesBlock ) : ?>
					<div class="col-12 col-lg-4">
						<div class="card features mb-4">
							<div class="card-body">
								<div class="media">
									<?php if ( isset($servicesBlock['icon']) && !empty($servicesBlock['icon']) ) : ?>
										<span class="<?= $servicesBlock['icon'] ?> gradient-fill ti-3x mr-3"></span>
									<?php endif; ?>
									<div class="media-body">
										<h4 class="card-title"> <?= $servicesBlock['title'] ?></h4>
										<p class="card-text"><?= $servicesBlock['description'] ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>


</div>
