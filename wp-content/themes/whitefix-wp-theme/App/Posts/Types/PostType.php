<?php


namespace App\Posts\Types;


abstract class PostType
{
	protected array $supports = [
		'title',
		'editor',
		'thumbnail',
		'custom-fields',
		'post-formats',
	];
	protected string $postSlug;
	protected string $postName;
	protected string $postTitle;
	protected string $postMenuIcon;

	public function __construct()
	{
		add_action('init', [ $this, 'registerPostType' ]);
	}

	protected function setLabels(): array
	{
		return [
			'name' => _x($this->postTitle, ' singular'),
			'singular_name' => _x($this->postTitle, ' singular'),
			'menu_name' => _x($this->postTitle, ' admin menu'),
			'name_admin_bar' => _x($this->postTitle, ' admin bar'),
			'add_new' => _x('Add New ' . $this->postName, ' add new'),
			'add_new_item' => __('Add New ' . $this->postName),
			'new_item' => __('New ' . $this->postName),
			'edit_item' => __('Edit ' . $this->postName),
			'view_item' => __('View ' . $this->postName),
			'all_items' => __('All ' . $this->postName),
			'search_items' => __('Search ' . $this->postName),
			'not_found' => __('No ' . $this->postName . ' found.'),
		];
	}

	public function registerPostType(): void
	{
		register_post_type($this->postSlug, $this->getPostTypeArgs());
	}

	abstract public function getPostTypeArgs(): array;
}
