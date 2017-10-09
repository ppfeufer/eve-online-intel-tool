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

	private $wpdb = null;

	protected function __construct() {
		parent::__construct();

		global $wpdb;

		$this->wpdb = $wpdb;
	}

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
		$this->createShipTable();
//		$this->createItemTable();
//		$this->createSolarsystemTable();

		/**
		 * Update database version
		 */
		\update_option($this->getDatabaseFieldName(), $newVersion);
	} // public function updateDatabase($newVersion)

	/**
	 * Creating the pilot table
	 */
	private function createPilotTable() {
		$charsetCollate = $this->wpdb->get_charset_collate();
		$tableName = $this->wpdb->prefix . 'eveIntelPilots';

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
	 */
	private function createCorporationTable() {
		$charsetCollate = $this->wpdb->get_charset_collate();
		$tableName = $this->wpdb->prefix . 'eveIntelCorporations';

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
	 */
	private function createAllianceTable() {
		$charsetCollate = $this->wpdb->get_charset_collate();
		$tableName = $this->wpdb->prefix . 'eveIntelAlliances';

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
	 */
	private function createShipTable() {
		$charsetCollate = $this->wpdb->get_charset_collate();
		$tableName = $this->wpdb->prefix . 'eveIntelShips';

		$sql = 'CREATE TABLE IF NOT EXISTS ' . $tableName . ' ('
			. 'ship_id bigint(11),'
			. 'class varchar(255),'
			. 'type varchar(255),'
			. 'category_id bigint(11),'
			. 'lastUpdated varchar(255),'
			. 'PRIMARY KEY id (ship_id)'
			. ') ' . $charsetCollate;

		require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

		\dbDelta($sql);

		$this->addMissingEsiShipData();
	} // private function createShipTable()

	/**
	 * Adding some ships that are not in the ESI to our database
	 */
	private function addMissingEsiShipData() {
		$tableName = $this->wpdb->prefix . 'eveIntelShips';

		// Capsule - Genolution 'Auroral' 197-variant
		if($this->wpdb->query('SELECT * FROM ' . $tableName . ' WHERE ship_id = 670;') === 0) {
			$this->wpdb->insert(
				$tableName,
				[
					'ship_id' => 670,
					'class' => 'Capsule',
					'type' => 'Capsule',
					'category_id' => 6,
					'lastUpdated' => '-1',
				]
			);
		}

		// Capsule
		if($this->wpdb->query('SELECT * FROM ' . $tableName . ' WHERE ship_id = 33328;') === 0) {
			$this->wpdb->insert(
				$tableName,
				[
					'ship_id' => 33328,
					'class' => 'Capsule - Genolution \'Auroral\' 197-variant',
					'type' => 'Capsule',
					'category_id' => 6,
					'lastUpdated' => '-1',
				]
			);
		}
	}

	/**
	 * Creating the items table
	 */
//	private function createItemTable() {
//		$charsetCollate = $this->wpdb->get_charset_collate();
//		$tableName = $this->wpdb->prefix . 'eveIntelItems';
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
	 */
//	private function createSolarsystemTable() {
//		$charsetCollate = $this->wpdb->get_charset_collate();
//		$tableName = $this->wpdb->prefix . 'eveIntelSolarsystems';
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
	 * @param string $characterID
	 * @return object
	 */
	public function getCharacterDataFromDb($characterID) {
		$returnValue = null;

		$characterResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelPilots' . ' WHERE character_id = %s',
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
	} // public function getCharacterDataFromDb($characterID)

	/**
	 * Get Character data from the DB (by character ID)
	 *
	 * @param string $characterName
	 * @return object
	 */
	public function getCharacterDataFromDbByName($characterName) {
		$returnValue = null;

		$characterResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelPilots' . ' WHERE name = %s',
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
	} // public function getCharacterDataFromDbByName($characterName)

	/**
	 * Writing character data into our database
	 *
	 * @param array $characterData (character_id, name, lastUpdated)
	 */
	public function writeCharacterDataToDb(array $characterData) {
		$this->wpdb->query($this->wpdb->prepare(
			'REPLACE INTO ' . $this->wpdb->prefix . 'eveIntelPilots' . ' (character_id, name, lastUpdated) VALUES (%s, %s, %s)',
			$characterData
		));
	} // public function writeCharacterdataToDb(array $characterData)

	/**
	 * Get the corporation data from the DB (by corporation ID)
	 *
	 * @param string $corporationID
	 * @return object
	 */
	public function getCorporationDataFromDb($corporationID) {
		$returnValue = null;

		$corporationResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelCorporations' . ' WHERE corporation_id = %s',
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
	} // public function getCorporationDataFromDb($corporationID)

	/**
	 * Get the corporation data from the DB (by corporation name)
	 *
	 * @param string $corporationName
	 * @return object
	 */
	public function getCorporationDataFromDbByName($corporationName) {
		$returnValue = null;

		$corporationResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelCorporations' . ' WHERE corporation_name = %s',
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
	 * Writing corporation data into our database
	 *
	 * @param array $corporationData (corporation_id, corporation_name, ticker, lastUpdated)
	 */
	public function writeCorporationDataToDb(array $corporationData) {
		$this->wpdb->query($this->wpdb->prepare(
			'REPLACE INTO ' . $this->wpdb->prefix . 'eveIntelCorporations' . ' (corporation_id, corporation_name, ticker, lastUpdated) VALUES (%s, %s, %s, %s)',
			$corporationData
		));
	} // public function writeCorporationDataToDb(array $corporationData)

	/**
	 * Get alliance Data from DB (by alliance ID)
	 *
	 * @param string $allianceID
	 * @return object
	 */
	public function getAllianceDataFromDb($allianceID) {
		$returnValue = null;

		$allianceResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelAlliances' . ' WHERE alliance_id = %s',
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
		$returnValue = null;

		$allianceResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelAlliances' . ' WHERE alliance_name = %s',
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

	/**
	 * Writing corporation data into our database
	 *
	 * @param array $allianceData (alliance_id, alliance_name, ticker, lastUpdated)
	 */
	public function writeAllianceDataToDb(array $allianceData) {
		$this->wpdb->query($this->wpdb->prepare(
			'REPLACE INTO ' . $this->wpdb->prefix . 'eveIntelAlliances' . ' (alliance_id, alliance_name, ticker, lastUpdated) VALUES (%s, %s, %s, %s)',
			$allianceData
		));
	} // END public function writeAllianceDataToDb(array $allianceData)

	/**
	 * Get ship data from DB (by ship ID)
	 *
	 * @param string $shipID
	 * @return object
	 */
	public function getShipDataFromDb($shipID) {
		$returnValue = null;

		$shipResult = $this->wpdb->get_results($this->wpdb->prepare(
			'SELECT * FROM ' . $this->wpdb->prefix . 'eveIntelShips' . ' WHERE ship_id = %s',
			[
				$shipID
			]
		));

		if($shipResult) {
			$returnValue = $shipResult['0'];
		}

		return $returnValue;
	}

	public function writeShipDataToDb(array $shipData) {
		$this->wpdb->query($this->wpdb->prepare(
			'REPLACE INTO ' . $this->wpdb->prefix . 'eveIntelShips' . ' (ship_id, class, type, category_id, lastUpdated) VALUES (%s, %s, %s, %d, %s)',
			$shipData
		));
	}
} // class DatabaseHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
