<?php

use App\Helpers\Posts;

?>
<div class="section light-bg" id="features">
	<div class="container">

		<div class="section-title">
			<small> <?= Posts::getAcfSubValue('subtitle') ?> </small>
			<h3> <?= Posts::getAcfSubValue('title') ?> </h3>
		</div>

		<div class="d-flex flex-column flex-lg-row">
			<span class="ti-info-alt gradient-fill ti-3x mr-3"></span>
			<div>
				<?= Posts::getAcfSubValue('content') ?>
			</div>
		</div>

	</div>
</div>
