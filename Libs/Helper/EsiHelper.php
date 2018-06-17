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
/**
 * EVE API Helper
 *
 * Getting some stuff from CCP's EVE API
 */
namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class EsiHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
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
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper
     */
    private $imageHelper = null;

    /**
     * Plugin Helper
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper
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
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper
     */
    private $cacheHelper = null;

    /**
     * Remote Helper
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\RemoteHelper
     */
    private $remoteHelper = null;

    /**
     * Database Helper
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\DatabaseHelper
     */
    private $databaseHelper = null;

    /**
     * ESI Search API
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\SearchApi
     */
    private $searchApi = null;

    /**
     * ESI Character API
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\CharacterApi
     */
    private $characterApi = null;

    /**
     * ESI Corporation API
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\CorporationApi
     */
    private $corporationApi = null;

    /**
     * ESI Alliance API
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\AllianceApi
     */
    private $allianceApi = null;

    /**
     * ESI Universe API
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\UniverseApi
     */
    private $universeApi = null;

    /**
     * The Constructor
     */
    protected function __construct() {
        parent::__construct();

        if(!$this->pluginHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper) {
            $this->pluginHelper = PluginHelper::getInstance();
            $this->pluginSettings = $this->pluginHelper->getPluginSettings();
        }

        if(!$this->imageHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper) {
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
        $this->searchApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\SearchApi;
        $this->characterApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\CharacterApi;
        $this->corporationApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\CorporationApi;
        $this->allianceApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\AllianceApi;
        $this->universeApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api\UniverseApi;
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
            $shipData = $this->universeApi->findTypeById($shipID);
            $shipClassData = $this->universeApi->findGroupById($shipData->group_id);

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
        $characterData = $this->databaseHelper->getCharacterDataFromDb($characterID);

        if(\is_null($characterData) || empty($characterData->name)) {
            $characterData = $this->characterApi->findById($characterID);

            if(!\is_null($characterData)) {
                $this->databaseHelper->writeCharacterDataToDb([
                    $characterID,
                    $characterData->name,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $characterData = $this->databaseHelper->getCharacterDataFromDb($characterID);
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
        $characterAffiliationData = $this->characterApi->findAffiliation(\array_values($characterIds));

        return [
            'data' => $characterAffiliationData
        ];
    }

    /**
     * Get corporation data by ID
     *
     * @global object $wpdb
     * @param string $corporationID
     * @return object
     */
    public function getCorporationData($corporationID) {
        $corporationData = $this->databaseHelper->getCorporationDataFromDb($corporationID);

        if(\is_null($corporationData) || empty($corporationData->corporation_name)) {
            $corporationData = $this->corporationApi->findById($corporationID);

            if(!\is_null($corporationData)) {
                $this->databaseHelper->writeCorporationDataToDb([
                    $corporationID,
                    $corporationData->name,
                    $corporationData->ticker,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $corporationData = $this->databaseHelper->getCorporationDataFromDb($corporationID);
            }
        }

        return [
            'data' => $corporationData
        ];
    }

    /**
     * Get alliance data by ID
     *
     * @global object $wpdb
     * @param string $allianceID
     * @return object
     */
    public function getAllianceData($allianceID) {
        $allianceData = $this->databaseHelper->getAllianceDataFromDb($allianceID);

        if(\is_null($allianceData) || empty($allianceData->alliance_name)) {
            $allianceData = $this->allianceApi->findById($allianceID);

            if(!\is_null($allianceData)) {
                $this->databaseHelper->writeAllianceDataToDb([
                    $allianceID,
                    $allianceData->name,
                    $allianceData->ticker,
                    \gmdate('Y-m-d H:i:s', \time())
                ]);

                $allianceData = $this->databaseHelper->getAllianceDataFromDb($allianceID);
            }
        }

        return [
            'data' => $allianceData
        ];
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
            $systemData = $this->universeApi->findSystemById($systemID);

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
            $constellationData = $this->universeApi->findConstellationById($constellationID);

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
            $regionData = $this->universeApi->findRegionById($regionID);

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

    /**
     * Get the EVE ID by it's name
     *
     * @param type $name
     * @param type $type
     * @return type
     */
    public function getEveIdFromName($name, $type) {
        $returnData = null;

        $arrayNotInApi = [
            \sanitize_title('Capsule') => [
                'name' => 'Capsule',
                'id' => 670
            ],
            \sanitize_title('Capsule - Genolution \'Auroral\' 197-variant') => [
                'name' => 'Capsule - Genolution \'Auroral\' 197-variant',
                'id' => 33328
            ]
        ];

        // Check DB first
        switch($type) {
            // Pilot
            case 'character':
                $characterData = $this->databaseHelper->getCharacterDataFromDbByName($name);

                if(isset($characterData->character_id)) {
                    $returnData = $characterData->character_id;
                }
                break;

            // Corporation
            case 'corporation':
                $corporationData = $this->databaseHelper->getCorporationDataFromDbByName($name);

                if(isset($corporationData->corporation_id)) {
                    $returnData = $corporationData->corporation_id;
                }
                break;

            // Alliance
            case 'alliance':
                $allianceData = $this->databaseHelper->getAllianceDataFromDbByName($name);

                if(isset($allianceData->alliance_id)) {
                    $returnData = $allianceData->alliance_id;
                }
                break;

            // Ship
            case 'inventory_type':
                $inventoryData = $this->databaseHelper->getShipDataFromDbByName($name);

                if(isset($inventoryData->ship_id)) {
                    $returnData = $inventoryData->ship_id;
                }
                break;

            // System
            case 'solar_system':
                $systemData = $this->databaseHelper->getSystemDataFromDbByName($name);

                if(isset($systemData->system_id)) {
                    $returnData = $systemData->system_id;
                }
                break;
        }

        // No data in our DB, let's get it from the ESI
        if(\is_null($returnData)) {
            if(isset($arrayNotInApi[\sanitize_title($name)])) {
                $returnData = $arrayNotInApi[\sanitize_title($name)]['id'];
            } else {
                $searchData = $this->searchApi->findIdByName(\trim($name), $type);

                /**
                 * -= FIX =-
                 *
                 * CCPs strict mode is not really strict, so we have to check manually ....
                 * Please CCP, get your shit sorted ...
                 */
                switch($type) {
                    case 'character':
                        if(!\is_null($searchData)) {
                            foreach($searchData->character as $characterID) {
                                $characterSheet = $this->getCharacterData($characterID);

                                if(\strtolower(\trim($characterSheet['data']->name)) === \strtolower(\trim($name))) {
                                    $returnData = $characterID;

                                    break;
                                }
                            }
                        }
                        break;

                    case 'corporation':
                        if(!\is_null($searchData)) {
                            foreach($searchData->corporation as $corporationID) {
                                $corporationSheet = $this->getCorporationData($corporationID);

                                if(\strtolower(\trim($corporationSheet['data']->corporation_name)) === \strtolower(\trim($name))) {
                                    $returnData = $corporationID;

                                    break;
                                }
                            }
                        }
                        break;

                    case 'alliance':
                        if(!\is_null($searchData)) {
                            foreach($searchData->alliance as $allianceID) {
                                $allianceSheet = $this->getAllianceData($allianceID);

                                if(\strtolower(\trim($allianceSheet['data']->alliance_name)) === \strtolower(\trim($name))) {
                                    $returnData = $allianceID;

                                    break;
                                }
                            }
                        }
                        break;

                    case 'solar_system':
                        if(!\is_null($searchData)) {
                            foreach($searchData->solar_system as $solarSystemID) {
                                $solarSystemData = $this->getSystemData($solarSystemID);

                                if(\strtolower(\trim($solarSystemData['data']->name)) === \strtolower(\trim($name))) {
                                    $returnData = $solarSystemID;

                                    break;
                                }
                            }
                        }
                        break;

                    case 'inventory_type':
                        if(!\is_null($searchData)) {
                            foreach($searchData->inventory_type as $inventoryTypeID) {
                                $inventorySheet = $this->getShipData($inventoryTypeID);

                                if(\strtolower($inventorySheet['data']['shipData']->name) === \strtolower(\trim($name))) {
                                    $returnData = $inventoryTypeID;

                                    break;
                                }
                            }
                        }
                        break;
                }
            }
        }

        return $returnData;
    }
}
