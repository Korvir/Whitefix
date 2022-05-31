<?php
/**
 * Template Name: Homepage
 */

get_header();

if ( !class_exists('ACF') )
{
	return false;
}
?>



<main role="main">
	<?php

	get_template_part('template-parts/static-blocks/hero', 'full');

	if ( have_rows('flexible_content') )
	{
		while ( have_rows('flexible_content') )
		{
			the_row();
			$layout = get_row_layout();
			$inclusion = get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'template-parts' . DIRECTORY_SEPARATOR . 'acf-blocks' . DIRECTORY_SEPARATOR . "{$layout}.php";

			if ( file_exists($inclusion) )
			{
				include( $inclusion );
			}

		}
	}
	?>
</main>



<?php get_footer(); ?>

