<?php

namespace App\Helpers;

class Posts
{

	/**
	 * @param string $selector
	 * @param string $post_id
	 *
	 * @return mixed|string
	 */
	public static function getAcfValue( string $selector, string $post_id = 'options' )
	{
		$output = get_field($selector, $post_id);

		if (!$output)
		{
			return '';
		}

		return $output;
	}


	/**
	 * @param string $selector
	 *
	 * @return mixed|string
	 */
	public static function getAcfSubValue( string $selector )
	{
		$output = get_sub_field($selector);

		if (!$output)
		{
			return '';
		}

		return $output;
	}


	/**
	 * @param int|null $post_id
	 * @return array
	 */
	public static function getTags( int $post_id = null ): array
	{
		$tags = ( $post_id ) ? get_the_terms($post_id, 'tax_tags') : get_the_terms(get_the_ID(), 'tax_tags');

		if (!$tags) return [];

		return $tags;
	}


	/**
	 * @param int|null $post_id
	 * @return string|null
	 */
	public static function setTagNames( int $post_id = null ): ?string
	{
		$tags = self::getTags($post_id);

		$tags_arr = [];

		if (!$tags) return null;

		foreach ($tags as $tag)
		{
			$tags_arr[] = $tag->name;
		}

		return implode(', ', $tags_arr);
	}


	/**
	 * @param int|null $post_id
	 * @return string|null
	 */
	public static function setTagIDs( int $post_id = null ): ?string
	{
		$tags = self::getTags($post_id);

		$tags_arr = [];

		if (!$tags) return null;

		foreach ($tags as $tag)
		{
			$tags_arr[] = $tag->term_id;
		}

		return implode(', ', $tags_arr);
	}


	/**
	 * @param int|null $post_id
	 * @return string|null
	 */
	public static function getPostType( int $post_id = null ): ?string
	{
		$post_type = $post_id ? get_post_type($post_id) : get_post_type(get_the_ID());

		if (!$post_type) return null;

		return $post_type;
	}


	/**
	 * @param $template
	 * @return string|null
	 */
	public static function getTplPageUrl( $template ): ?string
	{
		$url = null;
		$pages = get_pages([
			'meta_key' => '_wp_page_template',
			'meta_value' => $template
		]);

		if (isset($pages[0]))
		{
			$url = get_page_link($pages[0]->ID);
		}
		return $url;
	}


}
