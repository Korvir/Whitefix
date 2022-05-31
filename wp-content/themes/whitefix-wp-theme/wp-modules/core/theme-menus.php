<?php
add_action('after_setup_theme', 'theme_register_nav_menu');

function theme_register_nav_menu()
{
	register_nav_menus(
		array(
			'header-menu' => __('Header Menu'),
//			'footer-menu-1' => __('Footer Menu 1'),
//			'footer-menu-2' => __('Footer Menu 2')
		)
	);
}


# Menu list
function theme_nav()
{
	wp_nav_menu(
		array(
			'theme_location' => 'header-menu',
			'menu' => '',
			'container' => 'div',
			'container_class' => 'menu-{menu slug}-container',
			'container_id' => '',
			'menu_class' => 'menu',
			'menu_id' => '',
			'echo' => true,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => 0,
			'walker' => ''
		)
	);
}


// Remove the <div> surrounding the dynamic navigation to cleanup markup
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
function my_wp_nav_menu_args( $args = '' )
{
	$args['container'] = false;
	return $args;
}
