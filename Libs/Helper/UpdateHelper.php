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

use \Exception;
use \PclZip;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;
use \ZipArchive;

\defined('ABSPATH') or die();

class UpdateHelper extends AbstractSingleton {
    /**
     * Option field name for database version
     *
     * @var string
     */
    protected string $optionDatabaseFieldName = 'eve-online-intel-tool-database-version';

    /**
     * Database version
     *
     * @var int
     */
    protected int $databaseVersion = 20190611;

    /**
     * Database version
     *
     * @var int
     */
    protected int $esiClientVersion = 20210929;

    /**
     * WordPress Database Instance
     *
     * @var \wpdb
     */
    private $wpdb = null;

    /**
     * hasZipArchive
     *
     * Set true if ZipArchive PHP lib is installed
     *
     * @var bool
     */
    protected bool $hasZipArchive = false;

    /**
     * Constructor
     *
     * @global \wpdb $wpdb
     */
    protected function __construct() {
        parent::__construct();

        global $wpdb;

        $this->wpdb = $wpdb;
        $this->hasZipArchive = \class_exists('ZipArchive');
    }

    /**
     * getNewDatabaseVersion
     *
     * @return int
     */
    public function getNewDatabaseVersion(): int {
        return $this->databaseVersion;
    }

    /**
     * getNewEsiClientVersion
     *
     * @return int
     */
    public function getNewEsiClientVersion(): int {
        return $this->esiClientVersion;
    }

    /**
     * Returning the database version field name
     *
     * @return string
     */
    public function getDatabaseFieldName(): string {
        return $this->optionDatabaseFieldName;
    }

    /**
     * Getting the current database version
     *
     * @return string
     */
    public function getCurrentDatabaseVersion(): string {
        return \get_option($this->getDatabaseFieldName());
    }

    /**
     * Check if the database needs to be updated
     */
    public function checkDatabaseForUpdates(): void {
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
         * truncate cache table
         */
        if($currentVersion < 20190611) {
            $this->truncateCacheTable();
        }

        /**
         * Update database version
         */
        \update_option($this->getDatabaseFieldName(), $this->getNewDatabaseVersion());
    }

    /**
     * Update the plugin database
     */
    public function updateDatabase(): void {
        $this->createEsiCacheTable();
    }

    private function removeOldTables(): void {
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

    private function truncateCacheTable(): void {
        $tableName = $this->wpdb->base_prefix . 'eve_online_esi_cache';

        $sql = "TRUNCATE $tableName;";
        $this->wpdb->query($sql);
    }

    private function createEsiCacheTable(): void {
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

    /**
     * Check if the ESI clients needs to be updated
     */
    public function checkEsiClientForUpdates(): void {
        $esiClientCurrentVersion = null;

        /**
         * Check for current ESI client version
         */
        if(\class_exists('\WordPress\EsiClient\Swagger')) {
            $esiClient = new \WordPress\EsiClient\Swagger;

            if(\method_exists($esiClient, 'getEsiClientVersion')) {
                $esiClientCurrentVersion = $esiClient->getEsiClientVersion();
            }
        }

        // backwards compatibility with older ESI clients
        if(\is_null($esiClientCurrentVersion)) {
            if(\file_exists(\WP_CONTENT_DIR . '/EsiClient/client_version')) {
                $esiClientCurrentVersion = \trim(\file_get_contents(\WP_CONTENT_DIR . '/EsiClient/client_version'));
            }
        }

        if(\version_compare($esiClientCurrentVersion, $this->getNewEsiClientVersion()) < 0) {
            $this->updateEsiClient($this->getNewEsiClientVersion());
        }
    }

    /**
     * Updateing ESI client if needed
     *
     * @throws Exception
     */
    private function updateEsiClient(string $version = null): void {
        $remoteZipFile = 'https://github.com/ppfeufer/wp-esi-client/archive/master.zip';
        $dirInZipFile = '/wp-esi-client-master';

        if(!\is_null($version)) {
            $remoteZipFile = 'https://github.com/ppfeufer/wp-esi-client/archive/v' . $version . '.zip';
            $dirInZipFile = '/wp-esi-client-' . $version;
        }

        $esiClientZipFile = \WP_CONTENT_DIR . '/uploads/EsiClient.zip';

        \wp_remote_get($remoteZipFile, [
            'timeout' => 300,
            'stream' => true,
            'filename' => $esiClientZipFile
        ]);

        if(\is_dir(\WP_CONTENT_DIR . '/EsiClient/')) {
            $this->rrmdir(\WP_CONTENT_DIR . '/EsiClient/');
        }

        // extract using ZipArchive
        if($this->hasZipArchive === true) {
            $zip = new ZipArchive;
            if(!$zip->open($esiClientZipFile)) {
                throw new Exception('PHP-ZIP: Unable to open the Esi Client zip file');
            }

            if(!$zip->extractTo(\WP_CONTENT_DIR)) {
                throw new Exception('PHP-ZIP: Unable to extract Esi Client zip file');
            }

            $zip->close();
        }

        // extract using PclZip
        if($this->hasZipArchive === false) {
            require_once(\ABSPATH . 'wp-admin/includes/class-pclzip.php');

            $zip = new PclZip($esiClientZipFile);

            if(!$zip->extract(\PCLZIP_OPT_PATH, \WP_CONTENT_DIR)) {
                throw new Exception('PHP-ZIP: Unable to extract Esi Client zip file');
            }
        }

        \rename(\WP_CONTENT_DIR . $dirInZipFile, \WP_CONTENT_DIR . '/EsiClient/');

        \unlink($esiClientZipFile);
    }

    /**
     * Recursively remove directory
     *
     * @param string $dir
     */
    private function rrmdir(string $dir): void {
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
