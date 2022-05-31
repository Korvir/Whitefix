<?php

use App\Helpers\Str;

//add_action('pre_get_posts', 'excludeFromSearch');

/**
 * @param $query
 */
function excludeFromSearch( $query )
{

	if (
		!is_admin()
		&& $query->is_main_query()
		&& $query->is_search
		&& is_user_logged_in()
	)
	{

		$query->set('posts_per_page', 5);
		$query->set('post_type', [ 'post', 'capabilities' ]);

	}
}
