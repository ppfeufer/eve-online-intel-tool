<?php
/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class DatabaseHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * Option field name for database version
	 *
	 * @var string
	 */
	public $optionDatabaseFieldName = 'eve-online-intel-tool-database-version';

	/**
	 * Returniong the database version field name
	 *
	 * @return string
	 */
	public function getDatabaseFieldName() {
		return $this->optionDatabaseFieldName;
	} // public function getDatabaseFieldName()

	/**
	 * Getting the current database version
	 *
	 * @return string
	 */
	public function getCurrentDatabaseVersion() {
		return \get_option($this->getDatabaseFieldName());
	} // public function getCurrentDatabaseVersion()

	/**
	 * Check if the database needs to be updated
	 *
	 * @param string $newVersion New database version to check against
	 */
	public function checkDatabase($newVersion) {
		$currentVersion = $this->getCurrentDatabaseVersion();

		if(\version_compare($currentVersion, $newVersion, '<')) {
			$this->updateDatabase($newVersion);
		} // if(\version_compare($currentVersion, $newVersion, '<'))
	} // public function checkDatabase($newVersion)

	/**
	 * Update the plugin database
	 *
	 * @param string $newVersion New database version
	 */
	public function updateDatabase($newVersion) {
		$this->createPilotTable();
		$this->createCorporationTable();
		$this->createAllianceTable();
//		$this->createShipTable();
//		$this->createItemTable();
//		$this->createSolarsystemTable();

		/**
		 * Update database version
		 */
//		\update_option($this->getDatabaseFieldName(), $newVersion);
	} // public function updateDatabase($newVersion)

	/**
	 * Creating the pilot table
	 *
	 * @global object $wpdb
	 */
	private function createPilotTable() {
		global $wpdb;

		$charsetCollate = $wpdb->get_charset_collate();
		$tableName = $wpdb->prefix . 'eveIntelPilots';

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
			. 'character_id bigint(11),'
			. 'name varchar(255),'
			. 'lastUpdated varchar(255),'
			. 'PRIMARY KEY id (character_id)'
			. ') ' . $charsetCollate;

		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

		\dbDelta($sql);
	} // private function createPilotTable()

	/**
	 * Creating the corporation table
	 *
	 * @global object $wpdb
	 */
	private function createCorporationTable() {
		global $wpdb;

		$charsetCollate = $wpdb->get_charset_collate();
		$tableName = $wpdb->prefix . 'eveIntelCorporations';

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
			. 'corporation_id bigint(11),'
			. 'corporation_name varchar(255),'
			. 'ticker varchar(255),'
			. 'lastUpdated varchar(255),'
			. 'PRIMARY KEY id (corporation_id)'
			. ') ' . $charsetCollate;

		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

		\dbDelta($sql);
	} // private function createCorporationTable()

	/**
	 * Creating the alliance table
	 *
	 * @global object $wpdb
	 */
	private function createAllianceTable() {
		global $wpdb;

		$charsetCollate = $wpdb->get_charset_collate();
		$tableName = $wpdb->prefix . 'eveIntelAlliances';

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
			. 'alliance_id bigint(11),'
			. 'alliance_name varchar(255),'
			. 'ticker varchar(255),'
			. 'lastUpdated varchar(255),'
			. 'PRIMARY KEY id (alliance_id)'
			. ') ' . $charsetCollate;

		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

		\dbDelta($sql);
	} // private function createAllianceTable()

	/**
	 * Creating the ships table
	 *
	 * @global object $wpdb
	 */
//	private function createShipTable() {
//		global $wpdb;
//
//		$charsetCollate = $wpdb->get_charset_collate();
//		$tableName = $wpdb->prefix . 'eveIntelShips';
//
//		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
//			. 'eveID bigint(11),'
//			. 'class varchar(255),'
//			. 'type varchar(255),'
//			. 'lastUpdated varchar(255),'
//			. 'PRIMARY KEY id (eveID)'
//			. ') ' . $charsetCollate;
//
//		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');
//
//		\dbDelta($sql);
//
//		$this->addMissingEsiShipData();
//	} // private function createShipTable()

	/**
	 *
	 * @global object $wpdb
	 */
//	private function addMissingEsiShipData() {
//		global $wpdb;
//
//		$tableName = $wpdb->prefix . 'eveIntelShips';
//
//		// Capsule - Genolution 'Auroral' 197-variant
//		if($wpdb->query('SELECT * FROM ' . $tableName . ' WHERE eveID = 670;') === 0) {
//			$wpdb->insert(
//				$tableName,
//				[
//					'eveID' => 670,
//					'class' => 'Capsule',
//					'type' => 'Capsule',
//					'lastUpdated' => '-1',
//				]
//			);
//		}
//
//		// Capsule
//		if($wpdb->query('SELECT * FROM ' . $tableName . ' WHERE eveID = 33328;') === 0) {
//			$wpdb->insert(
//				$tableName,
//				[
//					'eveID' => 33328,
//					'class' => 'Capsule - Genolution \'Auroral\' 197-variant',
//					'type' => 'Capsule',
//					'lastUpdated' => '-1',
//				]
//			);
//		}
//	}

	/**
	 * Creating the items table
	 *
	 * @global object $wpdb
	 */
//	private function createItemTable() {
//		global $wpdb;
//
//		$charsetCollate = $wpdb->get_charset_collate();
//		$tableName = $wpdb->prefix . 'eveIntelItems';
//
//		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
//			. 'eveID bigint(11),'
//			. 'name varchar(255),'
//			. 'type varchar(255),'
//			. 'lastUpdated varchar(255),'
//			. 'PRIMARY KEY id (eveID)'
//			. ') ' . $charsetCollate;
//
//		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');
//
//		\dbDelta($sql);
//	} // private function createItemTable()

	/**
	 * Creating the items table
	 *
	 * @global object $wpdb
	 */
//	private function createSolarsystemTable() {
//		global $wpdb;
//
//		$charsetCollate = $wpdb->get_charset_collate();
//		$tableName = $wpdb->prefix . 'eveIntelSolarsystems';
//
//		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
//			. 'eveID bigint(11),'
//			. 'name varchar(255),'
//			. 'constellation varchar(255),'
//			. 'region varchar(255),'
//			. 'lastUpdated varchar(255),'
//			. 'PRIMARY KEY id (eveID)'
//			. ') ' . $charsetCollate;
//
//		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');
//
//		\dbDelta($sql);
//	} // private function createItemTable()

	/**
	 * Get Character data from the DB (by character ID)
	 *
	 * @global object $wpdb
	 * @param string $characterID
	 * @return object
	 */
	public function getCharacterDataFromDb($characterID) {
		global $wpdb;

		$returnValue = null;

		$characterResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelPilots' . ' WHERE character_id = %s',
			[
				$characterID
			]
		));

		if($characterResult) {
			$now = \time();
			$lastUpdated = \strtotime($characterResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated < 2592000) {
				$returnValue = $characterResult['0'];
			}
		}

		return $returnValue;
	}

	public function getCharacterDataFromDbByName($characterName) {
		global $wpdb;

		$returnValue = null;

		$characterResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelPilots' . ' WHERE name = %s',
			[
				$characterName
			]
		));

		if($characterResult) {
			$now = \time();
			$lastUpdated = \strtotime($characterResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated < 2592000) {
				$returnValue = $characterResult['0'];
			}
		}

		return $returnValue;
	}

	/**
	 * Get the corporation data from the DB (by corporation ID)
	 *
	 * @global object $wpdb
	 * @param string $corporationID
	 * @return object
	 */
	public function getCorporationDataFromDb($corporationID) {
		global $wpdb;

		$returnValue = null;

		$corporationResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelCorporations' . ' WHERE corporation_id = %s',
			[
				$corporationID
			]
		));

		if($corporationResult) {
			$now = \time();
			$lastUpdated = \strtotime($corporationResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated < 2592000) {
				$returnValue = $corporationResult['0'];
			}
		}

		return $returnValue;
	}

	public function getCorporationDataFromDbByName($corporationName) {
		global $wpdb;

		$returnValue = null;

		$corporationResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelCorporations' . ' WHERE corporation_name = %s',
			[
				$corporationName
			]
		));

		if($corporationResult) {
			$now = \time();
			$lastUpdated = \strtotime($corporationResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated < 2592000) {
				$returnValue = $corporationResult['0'];
			}
		}

		return $returnValue;
	}

	/**
	 * Get alliance Data from DB (by alliance ID)
	 *
	 * @global object $wpdb
	 * @param string $allianceID
	 * @return object
	 */
	public function getAllianceDataFromDb($allianceID) {
		global $wpdb;

		$returnValue = null;

		$allianceResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelAlliances' . ' WHERE alliance_id = %s',
			[
				$allianceID
			]
		));

		if($allianceResult) {
			$now = \time();
			$lastUpdated = \strtotime($allianceResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated > 2592000) {
				$returnValue = $allianceResult['0'];
			}
		}

		return $returnValue;
	}

	public function getAllianceDataFromDbByName($allianceName) {
		global $wpdb;

		$returnValue = null;

		$allianceResult = $wpdb->get_results($wpdb->prepare(
			'SELECT * FROM ' . $wpdb->prefix . 'eveIntelAlliances' . ' WHERE alliance_name = %s',
			[
				$allianceName
			]
		));

		if($allianceResult) {
			$now = \time();
			$lastUpdated = \strtotime($allianceResult['0']->lastUpdated);

			// Older than 30 days? Force an update
			if($now - $lastUpdated > 2592000) {
				$returnValue = $allianceResult['0'];
			}
		}

		return $returnValue;
	}
} // class DatabaseHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
