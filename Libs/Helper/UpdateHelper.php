<?php

/*
 * Copyright (C) 2018 ppfeufer
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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;
use ZipArchive;

\defined('ABSPATH') or die();

class UpdateHelper extends AbstractSingleton {
    /**
     * Option field name for database version
     *
     * @var string
     */
    protected $optionDatabaseFieldName = 'eve-online-intel-tool-database-version';

    /**
     * Database version
     *
     * @var string
     */
    protected $databaseVersion = 20181006;

    /**
     * Database version
     *
     * @var string
     */
    protected $esiClientVersion = 20181005;

    /**
     * WordPress Database Instance
     *
     * @var \wpdb
     */
    private $wpdb = null;

    /**
     * Constructor
     *
     * @global \wpdb $wpdb
     */
    protected function __construct() {
        parent::__construct();

        global $wpdb;

        $this->wpdb = $wpdb;
    }

    public function getNewDatabaseVersion() {
        return $this->databaseVersion;
    }

    public function getNewEsiClientVersion() {
        return $this->esiClientVersion;
    }

    /**
     * Returning the database version field name
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
     */
    public function checkDatabaseForUpdates() {
        $currentVersion = $this->getCurrentDatabaseVersion();

        if(\version_compare($currentVersion, $this->getNewDatabaseVersion()) < 0) {
            $this->updateDatabase($this->getNewDatabaseVersion());
        }

        /**
         * Remove old tables we don't need after this version
         */
        if($currentVersion < 20181006) {
            $this->removeOldTables();
        }

        /**
         * Update database version
         */
        \update_option($this->getDatabaseFieldName(), $this->getNewDatabaseVersion());
    }

    /**
     * Update the plugin database
     */
    public function updateDatabase() {
        $this->createEsiCacheTable();
    }

    private function removeOldTables() {
        $oldTableNames = [
            'eveIntelAlliances',
            'eveIntelConstellations',
            'eveIntelCorporations',
            'eveIntelPilots',
            'eveIntelRegions',
            'eveIntelShips',
            'eveIntelSystems',
            'eveOnlineEsiCache'
        ];

        foreach($oldTableNames as $tableName) {
            $tableToDrop = $this->wpdb->base_prefix . $tableName;
            $sql = "DROP TABLE IF EXISTS $tableToDrop;";
            $this->wpdb->query($sql);
        }
    }

    private function createEsiCacheTable() {
        $charsetCollate = $this->wpdb->get_charset_collate();
        $tableName = $this->wpdb->base_prefix . 'eve_online_esi_cache';

        $sql = "CREATE TABLE $tableName (
            esi_route varchar(255),
            value longtext,
            valid_until varchar(255),
            PRIMARY KEY esi_route (esi_route)
        ) $charsetCollate;";

        require_once(\ABSPATH . 'wp-admin/includes/upgrade.php');

        \dbDelta($sql);
    }

    public function checkEsiClientForUpdates() {
        $esiClientCurrentVersion = null;

        /**
         * Check for current ESI client version
         */
        if(\file_exists(\WP_CONTENT_DIR . '/EsiClient/client_version')) {
            $esiClientCurrentVersion = \trim(\file_get_contents(\WP_CONTENT_DIR . '/EsiClient/client_version'));
        }
        if(\version_compare($esiClientCurrentVersion, $this->getNewEsiClientVersion()) < 0) {
            $this->updateEsiClient();
        }
    }

    private function updateEsiClient() {
        $esiClientMasterZip = 'https://github.com/ppfeufer/wp-esi-client/archive/master.zip';
        $targetFile = \WP_CONTENT_DIR . '/uploads/EsiClient.zip';

        \wp_remote_get($esiClientMasterZip, [
            'timeout' => 300,
            'stream' => true,
            'filename' => $targetFile
        ]);

        if(\is_dir(\WP_CONTENT_DIR . '/EsiClient/')) {
            $this->rrmdir(\WP_CONTENT_DIR . '/EsiClient/');
        }

        $this->extractZipFile($targetFile, \WP_CONTENT_DIR . '/EsiClient/', \WP_CONTENT_DIR);

        \unlink($targetFile);
    }

    private function extractZipFile($zipfile, $destination, $temp_cache, $traverse_first_subdir = true) {
        $zip = new ZipArchive;

        if(\substr($temp_cache, -1) !== \DIRECTORY_SEPARATOR) {
            $temp_cache .= \DIRECTORY_SEPARATOR;
        }

        $res = $zip->open($zipfile);

        if($res === true) {
            if($traverse_first_subdir == true) {
                $zip_dir = $temp_cache . $zip->getNameIndex(0);
            } else {
                $temp_cache = $temp_cache . \basename($zipfile, ".zip");
                $zip_dir = $temp_cache;
            }

            $zip->extractTo($temp_cache);
            $zip->close();

            \rename($zip_dir, $destination);
        }
    }

    private function rrmdir($dir) {
        if(\is_dir($dir)) {
            $objects = \scandir($dir);

            foreach($objects as $object) {
                if($object != "." && $object != "..") {
                    if(\is_dir($dir . "/" . $object)) {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        \unlink($dir . "/" . $object);
                    }
                }
            }

            \rmdir($dir);
        }
    }
}
