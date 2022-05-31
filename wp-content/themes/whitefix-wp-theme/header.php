<!doctype html>
<html <?php use App\Helpers\Posts;
use App\Menu\MenuBuilder;

language_attributes(); ?>>

<head>

	<title>
		<?php wp_title(''); ?>

		<?php
		if ( wp_title('', false) )
		{
			echo ' :';
		}
		?>

		<?php bloginfo('name'); ?></title>

	<!-- Required meta tags -->
	<meta name="viewport"
	      content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<meta name="keywords" content="">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> data-spy="scroll" data-target="#navbar" data-offset="30">

<!-- Nav Menu -->
<header>

	<div class="nav-menu fixed-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<nav class="navbar navbar-dark navbar-expand-lg">

						<a class="navbar-brand"
						   href="<?= site_url() ?>">

							<img id="logo-header"
							     src="<?= Posts::getAcfValue('site_logo')['url'] ?>"
							     class="img-fluid"
							     alt="logo">
						</a>

						<?php if ( !empty(MenuBuilder::menuListItems('header-menu')) ): ?>

							<button class="navbar-toggler"
							        type="button"
							        data-toggle="collapse" data-target="#navbar"
							        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">

								<span class="navbar-toggler-icon"></span>
							</button>


							<div class="collapse navbar-collapse" id="navbar">
								<ul class="navbar-nav ml-auto">

									<?php foreach ( MenuBuilder::menuListItems('header-menu') as $key => $menu_item ) : ?>

										<?php $isActive = $key === 1 ? 'active' : ''; ?>
										<li class="nav-item">
											<a href="<?= $menu_item['url'] ?>"
											   class="nav-link <?= $isActive ?> <?= $menu_item['additional_classes'] ?>">
												<?= $menu_item['title'] ?>
											</a>

										</li>
									<?php endforeach; ?>

									<li class="nav-item">
										<a id="start_button"
										   class="btn btn-outline-light my-3 my-sm-0 ml-lg-3">
											ЗАЛИШИТИ ЗАЯВКУ
										</a>
									</li>

								</ul>
							</div>


						<?php endif; ?>

					</nav>

				</div>
			</div>
		</div>
	</div>


</header>

<?php wp_head(); ?>
