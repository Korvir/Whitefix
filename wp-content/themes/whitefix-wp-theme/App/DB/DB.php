<?php

namespace App\DB;

use wpdb;

class DB
{

	/**
	 * @var wpdb
	 */
	protected wpdb $wpdb;
	protected string $table;

	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
	}


	/**
	 * @param $sqlQuery
	 *
	 * @return array
	 */
	public function queryDB( $sqlQuery ): array
	{
		$results = $this->wpdb->get_results($sqlQuery, OBJECT);

		if ( !is_array($results) )
			return [];

		return $results;
	}


}
