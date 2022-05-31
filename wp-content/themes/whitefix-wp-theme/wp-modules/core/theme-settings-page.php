<?php

if (function_exists('acf_add_options_page')) {

    function for_acf_add_options_sub_page($name = '', $parent_slug = ''): array
    {
        return [
            'page_title' => 'Theme ' . $name . ' Settings',
            'menu_title' => $name,
            'parent_slug' => $parent_slug,
        ];
    }

    if (function_exists('acf_add_options_page')) {

        // Theme Settings
        acf_add_options_page(array(
            'page_title' => 'Налаштування теми',
            'menu_title' => 'Налаштування теми',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false
        ));




        // Pages Settings
//        acf_add_options_page(array(
//            'menu_title' => 'Pages Settings',
//            'menu_slug' => 'theme-pages-settings',
//            'capability' => 'edit_posts',
//        ));
//
//        acf_add_options_sub_page(
//            for_acf_add_options_sub_page('Party Mails Settings', 'theme-pages-settings')
//        );

//		acf_add_options_sub_page(
//			for_acf_add_options_sub_page('Capabilities Page', 'theme-pages-settings')
//		);
//
//		acf_add_options_sub_page(
//			for_acf_add_options_sub_page('404 Page', 'theme-pages-settings')
//		);

    }
}
