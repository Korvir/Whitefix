<?php

namespace App\PartyEvent;

use App\DB\DB;
use App\Logger\Logger;
use Carbon\Carbon;

class PartyEvent
{

	private \wpdb $wpdb;
	private string $table;
	private string $current_date;
	private int $cur_user;


	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->cur_user = wp_get_current_user()->exists()
			? wp_get_current_user()->ID
			: false;
		$this->table = $this->wpdb->prefix . 'event_activations';
		$this->current_date = ( new Carbon() )->now()->format('Y-m-d');
	}


	/**
	 * Get current active party
	 *
	 * @return array|false
	 */
	public function getActiveParty( $user_id = 0 )
	{

		$userID = wp_get_current_user()->ID;

		if ( $userID === 0 )
			return false;

		$sqlQuery = "
			SELECT
			    *
			FROM $this->table
			WHERE $this->table.user_id = $userID
			AND DATE($this->table.event_start) <= '$this->current_date'
		    AND DATE($this->table.event_end) >= '$this->current_date'
			ORDER BY $this->table.id DESC
			LIMIT 1
		";

		return ( new DB() )->queryDB($sqlQuery);

	}


	/**
	 * Get party for current user
	 *
	 * @param $userID
	 * @param $orderID
	 *
	 * @return array
	 */
	public function getCurrentParty( $userID, $orderID ): array
	{

		$sqlQuery = "
			SELECT
			    *
			FROM $this->table
			WHERE $this->table.user_id = $userID
			AND $this->table.order_id = $orderID
			AND $this->table.is_complete = 0
			ORDER BY $this->table.id DESC
			LIMIT 1
		";

		return ( new DB() )->queryDB($sqlQuery);

	}


	/**
	 * Get party by uuid
	 *
	 * @param $token
	 *
	 * @return array
	 */
	public function getParty( $token )
	{

		$sqlQuery = "
			SELECT
			    *
			FROM $this->table
			WHERE $this->table.uuid = $token
			AND $this->table.is_complete = 0
			ORDER BY $this->table.id DESC
			LIMIT 1
		";

		return ( new DB() )->queryDB($sqlQuery);

	}


	/**
	 * @return array|false
	 */
	public function createParty( $order = null )
	{


		if ( isset($order) && !empty($order) )
		{
			$userID = $order->get_user_id();
		}


		if ( $userID === 0 )
			return false;

		if ( !empty($this->getActiveParty($userID)) )
		{
			return false;
		}

		$token = wp_generate_uuid4();

		$this->wpdb->insert(
			$this->table,
			[
				'user_id' => $userID,
				'uuid' => $token,
				'order_id' => $order->get_id(),
			],
			[ '%d', '%s', '%d' ]
		);

		return [
			'id' => $this->wpdb->insert_id,
			'token' => $token
		];

	}


	/**
	 * Update party period (start, end).
	 * If not set new period - rewrite with current.
	 *
	 * @param        $token
	 * @param bool   $isComplete
	 * @param string $newDateStart
	 * @param string $newDateEnd
	 *
	 * @return bool|int|\mysqli_result|resource|null
	 */
	public function updatePartyPeriod( $token, bool $isComplete, string $newDateStart = '', string $newDateEnd = '' )
	{


		if ( !empty($this->getActiveParty($token)) )
		{
			return false;
		}

		$curParty = $this->getParty($token)[0];

		$complete_date = $isComplete
			? Carbon::now()->format('Y-m-d H:i:s')
			: null;

		return $this->wpdb->update(
			$this->table,
			[
				'event_start' => empty($newDateStart)
					? $curParty->event_start
					: Carbon::create($newDateStart)->format('Y-m-d H:i:s'),
				'event_end' => empty($newDateEnd)
					? $curParty->event_end
					: Carbon::create($newDateEnd)->format('Y-m-d H:i:s'),
				'is_complete' => $isComplete,
				'complete_date' => $complete_date
			],
			[ 'uuid' => $token ],
			[ '%s', '%s', '%d', '%s' ],
			[ '%s' ]
		);

	}




}
