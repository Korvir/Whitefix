<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/wp-modules/bootstrap.php';
require_once __DIR__ . '/App/_init.php';


if ( current_user_can('administrator') )
{
	show_admin_bar(false);
}

