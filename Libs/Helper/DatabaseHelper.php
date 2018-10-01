<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class DatabaseHelper extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * Option field name for database version
     *
     * @var string
     */
    public $optionDatabaseFieldName = 'eve-online-intel-tool-database-version';

    /**
     * WordPress Database Instance
     *
     * @var \WPDB
     */
    private $wpdb = null;

    /**
     * Constructor
     *
     * @global \WPDB $wpdb
     */
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
    }

    /**
     * Getting the current database version
     *
     * @return string
     */
    public function getCurrentDatabaseVersion() {
        return \get_option($this->getDatabaseFieldName());
    }

    /**
     * Check if the database needs to be updated
     *
     * @param string $newVersion New database version to check against
     */
    public function checkDatabase($newVersion) {
        $currentVersion = $this->getCurrentDatabaseVersion();

        if(!\is_null($newVersion)) {
            if(\version_compare($currentVersion, $newVersion) < 0) {
                $this->updateDatabase($newVersion);
            }
        }

        /**
         * Remove old tables we don't need after this version
         */
        if($currentVersion < 20181001) {
            $this->removeOldTables();
        }
    }

    /**
     * Update the plugin database
     *
     * @param string $newVersion New database version
     */
    public function updateDatabase($newVersion) {
        $this->createEsiCacheTable();

        /**
         * Update database version
         */
        \update_option($this->getDatabaseFieldName(), $newVersion);
    }

    private function removeOldTables() {
        $oldTableNames = [
            'eveIntelAlliances',
            'eveIntelConstellations',
            'eveIntelCorporations',
            'eveIntelPilots',
            'eveIntelRegions',
            'eveIntelShips',
            'eveIntelSystems'
        ];

        foreach($oldTableNames as $tableName) {
            $tableToDrop = $this->wpdb->base_prefix . $tableName;
            $sql = "DROP TABLE IF EXISTS $tableToDrop;";
            $this->wpdb->query($sql);
        }
    }

    private function createEsiCacheTable() {
        $charsetCollate = $this->wpdb->get_charset_collate();
        $tableName = $this->wpdb->base_prefix . 'eveOnlineEsiCache';

        $sql = "CREATE TABLE $tableName (
            esi_route varchar(255),
            value text,
            valid_until varchar(255),
            PRIMARY KEY esi_route (esi_route)
        ) $charsetCollate;";

        require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

        \dbDelta($sql);
    }

    /**
     * Getting cached Data from DB
     *
     * @param string $route
     * @return Esi Object
     */
    public function getCachedDataFromDb($route) {
        $returnValue = null;

        $cacheResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveOnlineEsiCache' . ' WHERE esi_route = %s AND valid_until > %s', [
                $route,
                \time()
            ]
        ));

        if($cacheResult) {
            $returnValue = \maybe_unserialize($cacheResult['0']->value);
        }

        return $returnValue;
    }

    /**
     * Write cache data into the DB
     *
     *
     * @param array $data ([esi_route, value, valid_until])
     */
    public function writeCacheDataToDb(array $data) {
        $this->wpdb->query($this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveOnlineEsiCache' . ' (esi_route, value, valid_until) VALUES (%s, %s, %s)', $data
        ));
    }

    /**
     * Get Character data from the DB (by character ID)
     *
     * @param string $characterID
     * @return object
     */
//    public function getCharacterDataFromDb($characterID) {
//        $returnValue = null;
//
//        $characterResult = $this->wpdb->get_results($this->wpdb->prepare(
//            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelPilots' . ' WHERE character_id = %s', [
//                $characterID
//            ]
//        ));
//
//        if($characterResult) {
//            $now = \strtotime(\gmdate('Y-m-d H:i:s', \time()));
//            $lastUpdated = \strtotime($characterResult['0']->lastUpdated);
//
//            // Older than 6 months? Force an update
//            if($now - $lastUpdated < 15552000) {
//                $returnValue = $characterResult['0'];
//            }
//        }
//
//        return $returnValue;
//    }

    /**
     * Get Character data from the DB (by character ID)
     *
     * @param string $characterName
     * @return object
     */
//    public function getCharacterDataFromDbByName($characterName) {
//        $returnValue = null;
//
//        $characterResult = $this->wpdb->get_results($this->wpdb->prepare(
//            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelPilots' . ' WHERE name = %s', [
//                $characterName
//            ]
//        ));
//
//        if($characterResult) {
//            $now = \strtotime(\gmdate('Y-m-d H:i:s', \time()));
//            $lastUpdated = \strtotime($characterResult['0']->lastUpdated);
//
//            // Older than 6 months? Force an update
//            if($now - $lastUpdated < 15552000) {
//                $returnValue = $characterResult['0'];
//            }
//        }
//
//        return $returnValue;
//    }

    /**
     * Writing character data into our database
     *
     * @param array $characterData (character_id, name, lastUpdated)
     */
//    public function writeCharacterDataToDb(array $characterData) {
//        $this->wpdb->query($this->wpdb->prepare(
//            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelPilots' . ' (character_id, name, lastUpdated) VALUES (%s, %s, %s)', $characterData
//        ));
//    }

    /**
     * Get the corporation data from the DB (by corporation ID)
     *
     * @param string $corporationID
     * @return object
     */
//    public function getCorporationDataFromDb($corporationID) {
//        $returnValue = null;
//
//        $corporationResult = $this->wpdb->get_results($this->wpdb->prepare(
//            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveOnlineEsiCache' . ' WHERE esi_route = %s AND valid_until > %s', [
//                'corporations/' . $corporationID . '/',
//                \time()
//            ]
//        ));
//
//        if($corporationResult) {
//            $returnValue = \maybe_unserialize($corporationResult['0']->value);
//        }
//
//        return $returnValue;
//    }

    /**
     * Writing corporation data into our database
     *
     * @param array $corporationData (esi_route, value, valid_until)
     */
//    public function writeCorporationDataToDb(array $corporationData) {
//        $this->wpdb->query($this->wpdb->prepare(
//            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveOnlineEsiCache' . ' (esi_route, value, valid_until) VALUES (%s, %s, %s)', $corporationData
//        ));
//    }

    /**
     * Get alliance Data from DB (by alliance ID)
     *
     * @param string $allianceID
     * @return object
     */
//    public function getAllianceDataFromDb($allianceID) {
//        $returnValue = null;
//
//        $allianceResult = $this->wpdb->get_results($this->wpdb->prepare(
//            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveOnlineEsiCache' . ' WHERE esi_route = %s AND valid_until > %s', [
//                'alliances/' . $allianceID . '/',
//                \time()
//            ]
//        ));
//
//        if($allianceResult) {
//            $now = \strtotime(\gmdate('Y-m-d H:i:s', \time()));
//            $lastUpdated = \strtotime($allianceResult['0']->lastUpdated);
//
//            // Older than 6 months? Force an update
//            if($now - $lastUpdated < 15552000) {
//                $returnValue = $allianceResult['0'];
//            }
//        }
//
//        return $returnValue;
//    }

    /**
     * Get alliance data from cache database by alliance name
     *
     * @param string $allianceName
     * @return object
     */
//    public function getAllianceDataFromDbByName($allianceName) {
//        $returnValue = null;
//
//        $allianceResult = $this->wpdb->get_results($this->wpdb->prepare(
//            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelAlliances' . ' WHERE alliance_name = %s', [
//                $allianceName
//            ]
//        ));
//
//        if($allianceResult) {
//            $now = \strtotime(\gmdate('Y-m-d H:i:s', \time()));
//            $lastUpdated = \strtotime($allianceResult['0']->lastUpdated);
//
//            // Older than 6 months? Force an update
//            if($now - $lastUpdated < 15552000) {
//                $returnValue = $allianceResult['0'];
//            }
//        }
//
//        return $returnValue;
//    }

    /**
     * Writing corporation data into our database
     *
     * @param array $allianceData (alliance_id, alliance_name, ticker, lastUpdated)
     */
//    public function writeAllianceDataToDb(array $allianceData) {
//        $this->wpdb->query($this->wpdb->prepare(
//            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelAlliances' . ' (alliance_id, alliance_name, ticker, lastUpdated) VALUES (%s, %s, %s, %s)', $allianceData
//        ));
//    }

    /**
     * Get system data from cache database by system ID
     *
     * @param int $systemID
     * @return object
     */
    public function getSystemDataFromDb($systemID) {
        $returnValue = null;

        $systemResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelSystems' . ' WHERE system_id = %s', [
                $systemID
            ]
        ));

        if($systemResult) {
            $returnValue = $systemResult['0'];
        }

        return $returnValue;
    }

    /**
     * Get system data from cache database by system Name
     *
     * @param string $systemName
     * @return object
     */
    public function getSystemDataFromDbByName($systemName) {
        $returnValue = null;

        $systemResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelSystems' . ' WHERE name = %s', [
                $systemName
            ]
        ));

        if($systemResult) {
            $returnValue = $systemResult['0'];
        }

        return $returnValue;
    }

    /**
     * Write system data to the cache database
     *
     * @param array $systemData (system_id, name, constellation_id, star_id, lastUpdated)
     */
    public function writeSystemDataToDb(array $systemData) {
        $this->wpdb->query($this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelSystems' . ' (system_id, name, constellation_id, star_id, lastUpdated) VALUES (%s, %s, %s, %s, %s)', $systemData
        ));
    }

    /**
     * Get the constellation data from the cache database by constellation ID
     *
     * @param int $constellationID
     * @return object
     */
    public function getConstellationDataFromDb($constellationID) {
        $returnValue = null;

        $constellationResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelConstellations' . ' WHERE constellation_id = %s', [
                $constellationID
            ]
        ));

        if($constellationResult) {
            $returnValue = $constellationResult['0'];
        }

        return $returnValue;
    }

    /**
     * Write constellation data to cache database
     *
     * @param array $constellationData (constellation_id, name, region_id, lastUpdated)
     */
    public function writeConstellationDataToDb(array $constellationData) {
        $this->wpdb->query($this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelConstellations' . ' (constellation_id, name, region_id, lastUpdated) VALUES (%s, %s, %s, %s)', $constellationData
        ));
    }

    /**
     * Get region data from cache database by region ID
     *
     * @param int $regionID
     * @return object
     */
    public function getRegionDataFromDb($regionID) {
        $returnValue = null;

        $regionResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelRegions' . ' WHERE region_id = %s', [
                $regionID
            ]
        ));

        if($regionResult) {
            $returnValue = $regionResult['0'];
        }

        return $returnValue;
    }

    /**
     * Write region data to cache database
     *
     * @param array $regionData (region_id, name, lastUpdated)
     */
    public function writeRegionDataToDb(array $regionData) {
        $this->wpdb->query($this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelRegions' . ' (region_id, name, lastUpdated) VALUES (%s, %s, %s)', $regionData
        ));
    }

    /**
     * Get ship data from DB (by ship ID)
     *
     * @param string $shipID
     * @return object
     */
    public function getShipDataFromDb($shipID) {
        $returnValue = null;

        $shipResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelShips' . ' WHERE ship_id = %s', [
                $shipID
            ]
        ));

        if($shipResult) {
            $returnValue = $shipResult['0'];
        }

        return $returnValue;
    }

    /**
     * Get ship data from DB (by ship name)
     *
     * @param string $shipName
     * @return object
     */
    public function getShipDataFromDbByName($shipName) {
        $returnValue = null;

        $shipResult = $this->wpdb->get_results($this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eveIntelShips' . ' WHERE class = %s', [
                $shipName
            ]
        ));

        if($shipResult) {
            $returnValue = $shipResult['0'];
        }

        return $returnValue;
    }

    /**
     * Write ship data to cache database
     *
     * @param array $shipData (ship_id, class, type, category_id, lastUpdated)
     */
    public function writeShipDataToDb(array $shipData) {
        $this->wpdb->query($this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eveIntelShips' . ' (ship_id, class, type, category_id, lastUpdated) VALUES (%s, %s, %s, %d, %s)', $shipData
        ));
    }

    /**
     * Get the number of cached pilots
     *
     * @return string
     */
//    public function getNumberOfPilotsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelPilots');
//    }

    /**
     * Get the number of cached corporations
     *
     * @return string
     */
//    public function getNumberOfCorporationsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelCorporations');
//    }

    /**
     * Get the number of cached alliances
     *
     * @return string
     */
//    public function getNumberOfAlliancesInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelAlliances');
//    }

    /**
     * Get the number of cached ships
     *
     * @return string
     */
//    public function getNumberOfShipsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelShips');
//    }

    /**
     * Get the number of cached systems
     *
     * @return string
     */
//    public function getNumberOfSystemsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelSystems');
//    }

    /**
     * Get the number of cached constellations
     *
     * @return string
     */
//    public function getNumberOfConstellationsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelConstellations');
//    }

    /**
     * Get the number of cached regions
     *
     * @return string
     */
//    public function getNumberOfRegionsInDatabase() {
//        return $this->wpdb->get_var('SELECT COUNT(*) FROM ' . $this->wpdb->base_prefix . 'eveIntelRegions');
//    }
}
