<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/wp-modules/bootstrap.php';
require_once __DIR__ . '/App/_init.php';


if ( current_user_can('administrator') )
{
	show_admin_bar(false);
}


// Redirect all to homepage
add_action('template_redirect', 'redirect_all_pages_to_home');
function redirect_all_pages_to_home()
{
	if ( !is_front_page() )
	{
		wp_redirect(get_home_url());
		exit;
	}
}


// Close all comments
add_filter('comments_open', 'filter_media_comment_status', 10, 2);
function filter_media_comment_status( $open, $post_id )
{
	return false;
}
