<?php


namespace App\Posts\Types;


class Insights
{

	public function __construct()
	{
		add_action( 'init', [ $this, 'rename_post_object_post'] );
	}

	/**
	 * Rename default post type "Post"
	 */
	public function rename_post_object_post()
    {
	    $get_post_type = get_post_type_object('post');

	    $labels = $get_post_type->labels;
	    $labels->name = 'Insights';
	    $labels->singular_name = 'Insights';
	    $labels->add_new = 'Add Insight';
	    $labels->add_new_item = 'Add Insight';
	    $labels->edit_item = 'Edit Insight';
	    $labels->new_item = 'Insight';
	    $labels->view_item = 'View Insights';
	    $labels->search_items = 'Search Insights';
	    $labels->not_found = 'No Insights found';
	    $labels->not_found_in_trash = 'No Insights found in Trash';
	    $labels->all_items = 'All Insights';
	    $labels->menu_name = 'Insights';
	    $labels->name_admin_bar = 'Insights';
    }
}
