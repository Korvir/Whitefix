<?php
/**
 * Pagination for paged posts, Page 1, Page 2, Page 3.
 * With Next and Previous Links
 *
 * Return HTML
 *
 */
function themeHtmlPagination()
{
	global $wp_query;

	$big = 999999999;

	echo paginate_links(array(
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	));

}


/**
 * Return array with:
 *
 * @param array $args {
 * @type int $total Max paginate page.
 * @type int $current Current page.
 * @type string $url_base URL pattern. Use {page_num} placeholder.
 * }
 *
 * @return array
 */
function themeRawPagination( array $args = [] ): array
{
	global $wp_query;

	$args = wp_parse_args($args, [
		'total' => $wp_query->max_num_pages ?? 1,
		'current' => max(1, get_query_var('paged')) ?? null,
		'url_base' => '', //
	]);

	if (null === $args['current'])
	{
		$args['current'] = max(1, get_query_var('paged', 1));
	}

	if (!$args['url_base'])
	{
		$args['url_base'] = str_replace(PHP_INT_MAX, '{page_num}', get_pagenum_link(PHP_INT_MAX));
	}

	$pages = range(1, max(1, (int)$args['total']));

	foreach ($pages as & $page)
	{
		$page = (object)[
			'is_current' => $page == $args['current'],
			'page_num' => $page,
			'url' => str_replace('{page_num}', $page, $args['url_base']),
		];
	}
	unset($page);

	return $pages;
}
