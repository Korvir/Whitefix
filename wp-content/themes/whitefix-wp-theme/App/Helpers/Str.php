<?php


namespace App\Helpers;


class Str
{

	/**
	 * Str constructor.
	 */
	public function __construct()
	{
		add_filter('the_content', [ $this, 'searchHighlight' ]);
		add_filter('get_the_excerpt', [ $this, 'searchHighlight' ]);
		add_filter('the_title', [ $this, 'searchHighlight' ]);
	}


	/**
	 * @param $value
	 * @param int $limit
	 * @param string $end
	 *
	 * @return mixed|string
	 */
	public static function limit( $value, $limit = 100, $end = '...' )
	{
		if (mb_strwidth($value, 'UTF-8') <= $limit)
		{
			return $value;
		}

		return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
	}


	/**
	 * @param $value
	 *
	 * @return array|false|string|string[]|null
	 */
	public static function lower( $value )
	{
		return mb_strtolower($value, 'UTF-8');
	}


	/**
	 * @param $value
	 * @param int $words
	 * @param string $end
	 *
	 * @return mixed|string
	 */
	public static function words( $value, $words = 100, $end = '...' )
	{
		preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);

		if (!isset($matches[0]) || static::length($value) === static::length($matches[0]))
		{
			return $value;
		}

		return rtrim($matches[0]) . $end;
	}


	/**
	 * @param int $length
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function random( $length = 16 ): string
	{
		$string = '';

		while (( $len = strlen($string) ) < $length)
		{
			$size = $length - $len;

			$bytes = random_bytes($size);

			$string .= substr(str_replace([ '/', '+', '=' ], '', base64_encode($bytes)), 0, $size);
		}

		return $string;
	}


	/**
	 * Highlight search words in specified text.
	 * Add more colors to array if needed to show difference colors.
	 *
	 * @param string $text The text you want to highlight the words in.
	 *
	 * @return string
	 *
	 * @version 0.1
	 */
	public static function searchHighlight( string $text ): string
	{

		// settings
		// not used here
		$styles = [ '',
			'color: #000; background: #99ff66;',
			'color: #000; background: #ffcc66;',
			'color: #000; background: #99ccff;',
			'color: #000; background: #ff9999;',
			'color: #000; background: #FF7EFF;',
		];

		// for the search pages and the main loop only.
		if (!is_search() || !in_the_loop())
			return $text;

		$query_terms = get_query_var('search_terms');

		if (empty($query_terms))
			$query_terms = array_filter((array)get_search_query());

		if (empty($query_terms))
			return $text;

		$n = 0;
		foreach ($query_terms as $term)
		{
			$n++;
			$term = preg_quote($term, '/');
			$text = preg_replace_callback("/$term/iu", static function( $match ) use ( $styles, $n )
			{
				return '<span class="search-found">' . $match[0] . '</span>';
			}, $text);
		}

		return $text;
	}

}
