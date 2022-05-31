<?php

namespace App\Menu;


class MenuBuilder
{

	/**
	 * @param $slug
	 * @return array|null
	 */
	public static function menuListItems( $slug ): ?array
	{
		$menu = [];
		if ($menu_items = wp_get_nav_menu_items($slug))
		{
			foreach ($menu_items as $item)
			{
				if (!$item->menu_item_parent)
				{
					// Compare menu object with current page menu object
					$current = (
						$_SERVER['REQUEST_URI'] == parse_url($item->url, PHP_URL_PATH) ||
						$_SERVER['REQUEST_URI'] == parse_url($item->url, PHP_URL_PATH) . '/'
					) ? 'active' : '';

					if ( is_array($item->classes))
					{
						$additionalClasses = implode(' ', $item->classes);
					}


					$menu[] = [
						'id' => $item->ID,
						'current_class' => $current,
						'additional_classes' => strtolower($additionalClasses),
						'slug' => strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $item->title)),
						'title' => $item->title,
						'url' => $item->url,
						'types' => []
					];


				} else
				{
					foreach ($menu as $key => $item_menu)
					{
						if ($item_menu['id'] == $item->menu_item_parent)
						{
							$current_sub = '';

							if (
								$_SERVER['REQUEST_URI'] == parse_url($item->url, PHP_URL_PATH) ||
								$_SERVER['REQUEST_URI'] == parse_url($item->url, PHP_URL_PATH) . '/'
							)
							{
								$current_sub = 'active';
								$menu[ $key ]['current_class'] = 'active';
							}

							if ( is_array($item->classes))
							{
								$additionalClasses = implode(' ', $item->classes);
							}


							$menu[ $key ]['types'][] = [
								'id' => $item->ID,
								'current_class' => $current_sub,
								'additional_classes' => strtolower($additionalClasses),
								'title' => $item->title,
								'url' => $item->url
							];
						}
					}
				}
			}
		}
//		dd($menu);

		return $menu;
	}

}
