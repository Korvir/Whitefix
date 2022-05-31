<?php

namespace App\Logger;

class Logger
{

	/**
	 * @param        $log
	 * @param string $log_file
	 */
	public function run( $log, $log_file = 'default_log' )
	{
		$date = '[' . date_i18n('D, Y-m-d H:i:s') . '] ';

		$uploads = wp_upload_dir();
		$logDir = $uploads['basedir'] . '/logs/';
		if ( !$this->folder_exist($logDir) )
		{
			mkdir($logDir);
		}


		if ( is_array($log) || is_object($log) )
		{
			error_log($date . print_r($log, true) . PHP_EOL, 3, trailingslashit($uploads['basedir']) . 'logs/' . $log_file . '.log');
		}
		else
		{
			error_log($date . $log . PHP_EOL, 3, trailingslashit($uploads['basedir']) . 'logs/' . $log_file . '.log');
		}

	}


	/**
	 * Check is log folder exist.
	 *
	 * @param $folder
	 *
	 * @return false|string
	 */
	private function folder_exist( $folder )
	{
		// Get canonicalized absolute pathname
		$path = realpath($folder);

		// If it exist, check if it's a directory
		return ( $path !== false and is_dir($path) ) ? $path : false;
	}
}
