<?php

use App\Helpers\Posts;

?>
<div class="section bg-gradient lozad"
     id="home"
     data-background-image="<?= Posts::getAcfValue('herofull_bg_image', get_the_ID())['url'] ?>">



	<div class="container mt-5 d-flex flex-column align-items-center justify-content-center position-relative">

		<h1 class="text-white"> <?= Posts::getAcfValue('herofull_title', get_the_ID()) ?> </h1>

		<p class="tagline">
			<?= Posts::getAcfValue('herofull_subtitle', get_the_ID()) ?>
		</p>


		<?php $button = Posts::getAcfValue('herofull_button', get_the_ID()); ?>

		<a id="start_button_promo"
		   href="<?= $button['url'] ?>"
		   class="btn btn-outline-light my-3 my-sm-0">
			<?= $button['title'] ?>
		</a>

	</div>

</div>
