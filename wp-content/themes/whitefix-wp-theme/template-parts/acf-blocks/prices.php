<?php

use App\Helpers\Posts;

?>
<div class="section light-bg" id="pricing">
	<div class="container">

		<div class="row">
			<div class="col-12">
				<div class="section-title text-center">
					<small> <?= Posts::getAcfSubValue('subtitle') ?> </small>
					<h3> <?= Posts::getAcfSubValue('title') ?> </h3>
				</div>
			</div>
		</div>


		<div class="row">
			<?php
			$priceBlocks = Posts::getAcfSubValue('blocks');

			if ( isset($priceBlocks) && !empty($priceBlocks) ) : ?>

				<?php foreach ( $priceBlocks as $priceBlock ) : ?>
					<div class="col-12 col-md-4 mb-4 ">
						<div class="card pricing popular ">
							<div class="d-flex flex-column align-items-center justify-content-center h-100 card-head  ">

								<small class="text-primary">
									<strong><?= $priceBlock['title'] ?> </strong>
								</small>

								<span class="price mt-auto mh-100">
									<sub> <?= $priceBlock['price_group']['before'] ?> </sub>
									<?= $priceBlock['price_group']['price'] ?>
									<sub><?= $priceBlock['price_group']['after'] ?> </sub>
								</span>

							</div>
						</div>
					</div>
				<?php endforeach; ?>


			<?php endif; ?>

		</div>

	</div>


	<!-- // end .pricing -->


</div>

