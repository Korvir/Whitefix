<?php


add_action('wp_enqueue_scripts', 'theme_scripts');
add_action('wp_enqueue_scripts', 'theme_styles');

add_action('init', 'theme_optimization_emoji');
add_action('wp_print_styles', 'theme_optimization', 100);

//add_filter('style_loader_src', 'sdt_remove_ver_css_js', 9999, 2);
//add_filter('script_loader_src', 'sdt_remove_ver_css_js', 9999, 2);


/**
 * Enqueue theme scripts
 */
function theme_scripts(): void
{

	$ver = wp_get_theme()->get('Version');

	wp_enqueue_script('app', get_stylesheet_directory_uri() . '/dist/js/app.js', [], $ver, true);



	$ajax_params = [
		'ajaxurl' => admin_url('admin-ajax.php'),
	];
	wp_localize_script('app', 'jsVars', $ajax_params);
}


/**
 * Enqueue theme stylesheets
 */
function theme_styles(): void
{
	$ver = wp_get_theme()->get('Version');

	wp_enqueue_style('app', get_stylesheet_directory_uri() . '/dist/css/app.css', [], $ver, 'all');
	wp_enqueue_style('themify-icons', get_stylesheet_directory_uri() . '/dist/css/themify-icons.css', [], $ver, 'all');

}


//function admin_assets()
//{
//	wp_enqueue_style('theme-admin-style', get_template_directory_uri() . '/dist/admin_style.css');
//	wp_enqueue_script('theme-admin-script', get_template_directory_uri() . '/dist/admin_script.js');
//}


function sdt_remove_ver_css_js( $src, $handle )
{
	$handles_with_version = [ 'style' ]; // <-- Adjust to your needs!
	if ( strpos($src, 'ver=') && !in_array($handle, $handles_with_version, true) )
	{
		$src = remove_query_arg('ver', $src);
	}

	return $src;
}


function theme_optimization()
{
	// Disable Dashicons
	wp_deregister_style('dashicons');

	// Disable Gutenberg block styles
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS

}

function theme_optimization_emoji()
{
	// Disable emoji
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
