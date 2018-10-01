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

/**
 * EVE API Helper
 *
 * Getting some stuff from CCP's EVE API
 */
namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class EsiHelper extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * Image Server URL
     *
     * @var string
     */
    private $imageserverUrl = null;

    /**
     * Image Server Endpoints
     *
     * @var array
     */
    private $imageserverEndpoints = null;

    /**
     * Plugin Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper
     */
    private $imageHelper = null;

    /**
     * Plugin Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper
     */
    private $pluginHelper = null;

    /**
     * Plugin Settings
     *
     * @var array
     */
    private $pluginSettings = null;

    /**
     * Cache Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\CacheHelper
     */
    private $cacheHelper = null;

    /**
     * Remote Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper
     */
    private $remoteHelper = null;

    /**
     * Database Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\DatabaseHelper
     */
    private $databaseHelper = null;

    /**
     * ESI Character API
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\CharacterRepository
     */
    private $characterApi = null;

    /**
     * ESI Corporation API
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\CorporationRepository
     */
    private $corporationApi = null;

    /**
     * ESI Alliance API
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\AllianceRepository
     */
    private $allianceApi = null;

    /**
     * ESI Universe API
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Api\UniverseApi
     */
    private $universeApi = null;

    /**
     * The Constructor
     */
    protected function __construct() {
        parent::__construct();

        if(!$this->pluginHelper instanceof \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper) {
            $this->pluginHelper = PluginHelper::getInstance();
            $this->pluginSettings = $this->pluginHelper->getPluginSettings();
        }

        if(!$this->imageHelper instanceof \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper) {
            $this->imageHelper = ImageHelper::getInstance();
            $this->imageserverEndpoints = $this->imageHelper->getImageserverEndpoints();
            $this->imageserverUrl = $this->imageHelper->getImageServerUrl();
        }

        $this->databaseHelper = DatabaseHelper::getInstance();
        $this->cacheHelper = CacheHelper::getInstance();
        $this->remoteHelper = RemoteHelper::getInstance();

        /**
         * ESI API Client
         */
        $this->characterApi = new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\CharacterRepository;
        $this->corporationApi = new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\CorporationRepository;
        $this->allianceApi = new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\AllianceRepository;
        $this->universeApi = new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository\UniverseRepository;
    }

    /**
     * Getting all the needed ship information from the ESI
     *
     * @param int $shipID
     * @return array
     */
    public function getShipData($shipID) {
        $returnData = null;
        $shipData = null;
        $shipClassData = null;

        $resultDB = $this->databaseHelper->getShipDataFromDb($shipID);

        if(\is_null($resultDB)) {
            $shipData = $this->universeApi->universeTypesTypeId($shipID);
            $shipClassData = $this->universeApi->universeGroupsGroupId($shipData->group_id);

            if(!\is_null($shipData) && !\is_null($shipClassData)) {
                $this->databaseHelper->writeShipDataToDb([
                    $shipData->type_id,
                    $shipData->name,
                    $shipClassData->name,
                    $shipClassData->category_id,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                unset($shipData);
                unset($shipClassData);

                $resultDB = $this->databaseHelper->getShipDataFromDb($shipID);
            }
        }

        if(!\is_null($resultDB)) {
            $shipData = new \stdClass();
            $shipData->type_id = $resultDB->ship_id;
            $shipData->name = $resultDB->class;

            $shipClassData = new \stdClass();
            $shipClassData->name = $resultDB->type;
            $shipClassData->category_id = (int) $resultDB->category_id;
        }

        if(!\is_null($shipData) && !\is_null($shipClassData)) {
            $returnData = [
                'data' => [
                    'shipData' => $shipData,
                    'shipTypeData' => $shipClassData
                ]
            ];
        }

        return $returnData;
    }

    /**
     * Get the character data for a characterID
     *
     * @param string $characterID
     * @return array
     */
    public function getCharacterData($characterID) {
        $characterData = $this->databaseHelper->getCachedDataFromDb('characters/' . $characterID);

        if(\is_null($characterData) || empty($characterData->name)) {
            $characterData = $this->characterApi->charactersCharacterId($characterID);

            if(!\is_null($characterData)) {
                $this->databaseHelper->writeCacheDataToDb([
                    'characters/' . $characterID,
                    \maybe_serialize($characterData),
                    \strtotime('+1 week')
                ]);

                $characterData = $this->databaseHelper->getCachedDataFromDb('characters/' . $characterID);
            }
        }

        return [
            'data' => $characterData
        ];
    }

    /**
     * Get the affiliation for a set of characterIDs
     *
     * @param array $characterIds
     * @return array
     */
    public function getCharacterAffiliation(array $characterIds) {
        $characterAffiliationData = $this->characterApi->charactersAffiliation(\array_values($characterIds));

        return $characterAffiliationData;
    }

    /**
     * Get the IDs to an array of names
     *
     * @param array $names
     * @param string $type
     * @return type
     */
    public function getIdFromName(array $names, $type) {
        $returnData = null;

        /* @var $esiData \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Model\Universe\UniverseIds */
        $esiData = $this->universeApi->universeIds(\array_values($names));

        switch($type) {
            case 'agents':
                $returnData = $esiData->getAgents();
                break;

            case 'alliances':
                $returnData = $esiData->getAlliances();
                break;

            case 'constellations':
                $returnData = $esiData->getConstellations();
                break;

            case 'characters':
                $returnData = $esiData->getCharacters();
                break;

            case 'corporations':
                $returnData = $esiData->getCorporations();
                break;

            case 'factions':
                $returnData = $esiData->getFactions();
                break;

            case 'inventoryTypes':
                $returnData = $esiData->getInventoryTypes();
                break;

            case 'regions':
                $returnData = $esiData->getRegions();
                break;

            case 'stations':
                $returnData = $esiData->getStations();
                break;

            case 'systems':
                $returnData = $esiData->getSystems();
                break;
        }

        return $returnData;
    }

    /**
     * Get corporation data by ID
     *
     * @global object $wpdb
     * @param string $corporationID
     * @return object
     */
    public function getCorporationData($corporationID) {
        /* @var $corporationData \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Model\Corporation\CorporationsCorporationId */
        $corporationData = $this->databaseHelper->getCachedDataFromDb('corporations/' . $corporationID);

        if(\is_null($corporationData) || empty($corporationData->corporation_name)) {
            $corporationData = $this->corporationApi->corporationsCorporationId($corporationID);

            if(!\is_null($corporationData)) {
                $this->databaseHelper->writeCacheDataToDb([
                    'corporations/' . $corporationID,
                    \maybe_serialize($corporationData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $corporationData;
    }

    /**
     * Get alliance data by ID
     *
     * @global object $wpdb
     * @param string $allianceID
     * @return object
     */
    public function getAllianceData($allianceID) {
        $allianceData = $this->databaseHelper->getCachedDataFromDb('alliances/' . $allianceID);

        if(\is_null($allianceData) || empty($allianceData->alliance_name)) {
            $allianceData = $this->allianceApi->alliancesAllianceId($allianceID);

            if(!\is_null($allianceData)) {
                $this->databaseHelper->writeCacheDataToDb([
                    'alliances/' . $allianceID,
                    \maybe_serialize($allianceData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $allianceData;
    }

    /**
     * Getting all the needed system information from the ESI
     *
     * @param int $systemID
     * @return array
     */
    public function getSystemData($systemID) {
        $systemData = $this->databaseHelper->getSystemDataFromDb($systemID);

        if(\is_null($systemData) || empty($systemData->name)) {
            $systemData = $this->universeApi->universeSystemsSystemId($systemID);

            if(!\is_null($systemData)) {
                $this->databaseHelper->writeSystemDataToDb([
                    $systemID,
                    $systemData->name,
                    $systemData->constellation_id,
                    $systemData->star_id,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $systemData = $this->databaseHelper->getSystemDataFromDb($systemID);
            }
        }

        return [
            'data' => $systemData
        ];
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $constellationID
     * @return array
     */
    public function getConstellationData($constellationID) {
        $constellationData = $this->databaseHelper->getConstellationDataFromDb($constellationID);

        if(\is_null($constellationData) || empty($constellationData->name)) {
            $constellationData = $this->universeApi->universeConstellationsConstellationId($constellationID);

            if(!\is_null($constellationData)) {
                $this->databaseHelper->writeConstellationDataToDb([
                    $constellationID,
                    $constellationData->name,
                    $constellationData->region_id,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $constellationData = $this->databaseHelper->getConstellationDataFromDb($constellationID);
            }
        }

        return [
            'data' => $constellationData
        ];
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $regionID
     * @return array
     */
    public function getRegionData($regionID) {
        $regionData = $this->databaseHelper->getRegionDataFromDb($regionID);

        if(\is_null($regionData) || empty($regionData->name)) {
            $regionData = $this->universeApi->universeRegionsRegionId($regionID);

            if(!\is_null($regionData)) {
                $this->databaseHelper->writeRegionDataToDb([
                    $regionID,
                    $regionData->name,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $regionData = $this->databaseHelper->getRegionDataFromDb($regionID);
            }
        }

        return [
            'data' => $regionData
        ];
    }
}
