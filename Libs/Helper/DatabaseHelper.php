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
}
