<?php


namespace App\Posts\Types;


class Party extends PostType
{

	protected string $postSlug = 'party';
	protected string $postName = 'party';
	protected string $postTitle = 'Party Event';
	protected string $postMenuIcon = 'dashicons-text-page';

	public function getPostTypeArgs(): array
	{
		return [
			'supports' => $this->supports,
			'labels' => $this->setLabels(),
			'public' => true,
			'query_var' => true,
			'rewrite' => [ 'slug' => $this->postSlug ],
			'has_archive' => true,
			'hierarchical' => true,
			'menu_icon' => $this->postMenuIcon,
			'menu_position' => 5,
			'show_in_rest' => true,
		];
	}

}
