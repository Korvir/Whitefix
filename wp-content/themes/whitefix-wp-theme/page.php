<?php
get_header();
?>

	<main role="main">


		<section class="typical-section">
			<div class="container">
				<div class="row justify-content-center">


					<div class="col-xl-12 col-xxl-12">

						<h1 class="typical-title">
							<?php the_title() ?>
						</h1>

						<div class="typical-content">
							<?= get_the_content() ?>
						</div>

					</div>


				</div>
			</div>
		</section>


	</main>

<?php get_footer(); ?>
