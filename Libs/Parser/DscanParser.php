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
namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Parser;

\defined('ABSPATH') or die();

class DscanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper
     */
    private $esi = null;

    /**
     * String Helper
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\StringHelper
     */
    private $stringHelper = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esi = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
        $this->stringHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\StringHelper::getInstance();
    }

    /**
     * Breaking down the D-Scan into arrays
     *
     * @param string $scanData
     * @return array
     */
    public function getDscanArray($scanData) {
        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = $this->stringHelper->fixLineBreaks($scanData);

        $dscanDetailShipsAll = [];
        $dscanDetailShipsOnGrid = [];
        $dscanDetailShipsOffGrid = [];

        foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            $shipData = $this->esi->getShipData($lineDetailsArray['0']);

            if($shipData['data']['shipData'] !== null && $shipData['data']['shipTypeData'] !== null) {
                $dscanDetailShipsAll[] = [
                    'dscanData' => $lineDetailsArray,
                    'shipData' => $shipData['data']['shipData'],
                    'shipClass' => $shipData['data']['shipTypeData']
                ];

                /**
                 * Determine OnGrid and OffGrid
                 */
                if($lineDetailsArray['3'] === '-') {
                    $dscanDetailShipsOffGrid[] = [
                        'dscanData' => $lineDetailsArray,
                        'shipData' => $shipData['data']['shipData'],
                        'shipClass' => $shipData['data']['shipTypeData']
                    ];
                } else {
                    $dscanDetailShipsOnGrid[] = [
                        'dscanData' => $lineDetailsArray,
                        'shipData' => $shipData['data']['shipData'],
                        'shipClass' => $shipData['data']['shipTypeData']
                    ];
                }
            }
        }

        // Let's see if we can find out in what system we are ....
        $system = $this->detectSystem($cleanedScanData);

        $dscanArray = [
            'all' => [
                'count' => \count($dscanDetailShipsAll),
                'data' => $dscanDetailShipsAll
            ],
            'onGrid' => [
                'count' => \count($dscanDetailShipsOnGrid),
                'data' => $dscanDetailShipsOnGrid
            ],
            'offGrid' => [
                'count' => \count($dscanDetailShipsOffGrid),
                'data' => $dscanDetailShipsOffGrid
            ],
            'system' => $system
        ];

        return $dscanArray;
    }

    /**
     * Try and detect the system the scan was made in
     *
     * @param string $cleanedScanData
     * @return array
     */
    public function detectSystem($cleanedScanData) {
        $returnValue = null;

        /**
         * Trying to find the system by one of the structure IDs
         */
        $systemInfo = $this->detectSystemByUpwellStructure($cleanedScanData);

        /**
         * Determine system by its sun if we couldn't get
         * a system from an Upwell structure
         */
        if($systemInfo['systemFound'] === false) {
            $systemInfo = $this->detectSystemBySun($cleanedScanData);
        }

        /**
         * If we have a system name, get the system data,
         * like constellation and region
         */
        if($systemInfo['systemName'] !== null) {
            $returnValue = $this->getSystemInformationBySystemName($systemInfo['systemName']);
        }

        return $returnValue;
    }

    /**
     * Detecting the system by Upwell structures on d-scan
     *
     * @param string $scandata
     * @return array
     */
    public function detectSystemByUpwellStructure($scandata) {
        $systemFound = false;
        $systemName = null;

        $upwellStructureIds = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\StructureHelper::getInstance()->getUpwellStructureIds();

        foreach(\explode("\n", \trim($scandata)) as $line) {
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            if(\in_array($lineDetailsArray['0'], $upwellStructureIds)) {
                $parts = \explode(' - ', $lineDetailsArray['1']);
                $systemName = \trim($parts['0']);

                $systemFound = true;
            }
        }

        return [
            'systemFound' => $systemFound,
            'systemName' => $systemName
        ];
    }

    /**
     * Detecting the system by it's sun on d-scan
     *
     * @param string $scandata
     * @return array
     */
    public function detectSystemBySun($scandata) {
        $systemFound = false;
        $systemName = null;

        foreach(\explode("\n", \trim($scandata)) as $line) {
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            if(\preg_match('/(.*) - Star/', $lineDetailsArray['1']) && \preg_match('/Sun (.*)/', $lineDetailsArray['2'])) {
                $systemName = \trim(\str_replace(' - Star', '', $lineDetailsArray['1']));
            }
        }

        return [
            'systemFound' => $systemFound,
            'systemName' => $systemName
        ];
    }

    /**
     * Get the system information from the system name.
     *
     * @param type $systemName
     * @return type
     */
    public function getSystemInformationBySystemName($systemName) {
        $returnValue = null;
        $systemData = $this->esi->getIdFromName([\trim($systemName)], 'systems');

        if(!\is_null($systemData)) {
            $systemData = $this->esi->getSystemData($systemData['0']->id);
            $constellationName = null;
            $regionName = null;

            // Get the constellation data
            $constellationData = $this->esi->getConstellationData($systemData['data']->constellation_id);

            // Set the constellation name
            if(!\is_null($constellationData)) {
                $constellationName = $constellationData['data']->name;

                // Get the region data
                $regionData = $this->esi->getRegionData($constellationData['data']->region_id);

                // Set the region name
                if(!\is_null($regionData)) {
                    $regionName = $regionData['data']->name;
                }
            }

            $returnValue = [
                 'systemName' => $systemName,
                 'constellationName' => $constellationName,
                 'regionName' => $regionName
             ];
        }

        return $returnValue;
    }

    /**
     * Parsing the D-Scan arrays
     *
     * @param array $dscanArray
     * @return array
     */
    public function parseScanArray(array $dscanArray) {
        $returnData = null;
        $countShipClasses = [];
        $dscanDetails = [];
        $count = [];
        $shipCounter = 0;

        foreach($dscanArray['data'] as $item) {
            switch($item['shipClass']->category_id) {
                // only ships
                case 6:
                    /**
                     * Counter Ship Types
                     */
                    $count[$item['dscanData']['0']]['all'][] = '';
                    $dscanDetails['count'] = ++$shipCounter;

                    /**
                     * Counter Ship Classes
                     */
                    $countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->name)]['shipClass'] = (string) $item['shipClass']->name;
                    $countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->name)]['counter'][] = '';

                    /**
                     * Ship breakdown
                     */
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipID'] = $item['dscanData']['0'];
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipName'] = $item['dscanData']['2'];
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['count'] = \count($count[$item['dscanData']['0']]['all']);
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipClass'] = $item['shipClass']->name;
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipTypeSanitized'] = \sanitize_title((string) $item['shipClass']->name);
                    break;

                default:
                    break;
            }
        }

        if(!empty($dscanDetails['data'])) {
            \ksort($dscanDetails['data']);

            $returnData = $dscanDetails;
        }

        return $returnData;
    }

    /**
     * Parsing the D-Scan
     *
     * @param string $scanData
     * @return array
     */
    public function parseDscan($scanData) {
        $returnData = null;
        $dscanAll = null;
        $dscanOnGrid = null;
        $dscanOffGrid = null;

        $dscanArray = $this->getDscanArray($scanData);

        if($dscanArray['all']['count'] !== 0) {
            $dscanAll = $this->parseScanArray($dscanArray['all']);
            $returnData['all'] = $dscanAll;

            $returnData['shipTypes'] = $this->getShipTypesArray($dscanArray['all']['data']);
            $returnData['upwellStructures'] = $this->getUpwellStructuresArray($dscanArray['all']['data']);
            $returnData['deployables'] = $this->getDeployablesArray($dscanArray['all']['data']);
            $returnData['starbaseModules'] = $this->getStarbaseArray($dscanArray['all']['data']);
            $returnData['lootSalvage'] = $this->getLootSalvageArray($dscanArray['all']['data']);
        }

        if($dscanArray['onGrid']['count'] !== 0) {
            $dscanOnGrid = $this->parseScanArray($dscanArray['onGrid']);
            $returnData['onGrid'] = $dscanOnGrid;
        }

        if($dscanArray['offGrid']['count'] !== 0) {
            $dscanOffGrid = $this->parseScanArray($dscanArray['offGrid']);
            $returnData['offGrid'] = $dscanOffGrid;
        } // if($dscanArray['onGrid']['count'] !== 0)

        $returnData['system'] = $dscanArray['system'];

        return $returnData;
    }

    /**
     * Getting the shiptypes array
     *
     * @param array $dscanArray
     * @return array
     */
    public function getShipTypesArray(array $dscanArray) {
        $shipTypeArray = [];
        $count = [];

        foreach($dscanArray as $scanResult) {
            // Ships only ...
            if($scanResult['shipClass']->category_id === 6) {
                if(!isset($count[\sanitize_title($scanResult['shipClass']->name)])) {
                    $count[\sanitize_title($scanResult['shipClass']->name)] = 0;
                } // if(!isset($count[\sanitize_title($scanResult['shipClass']->name)]))

                $count[\sanitize_title($scanResult['shipClass']->name)] ++;

                $shipTypeArray[\sanitize_title($scanResult['shipClass']->name)] = [
                    'type' => $scanResult['shipClass']->name,
                    'shipTypeSanitized' => \sanitize_title($scanResult['shipClass']->name),
                    'count' => $count[\sanitize_title($scanResult['shipClass']->name)]
                ];
            }
        }

        \ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Getting Upwell structures that are on grid
     *
     * @param array $dscanArray
     * @return array
     */
    public function getUpwellStructuresArray(array $dscanArray) {
        $shipTypeArray = [];
        $count = [];
        $gridSize = 10000; // our defined grid size in km

        foreach($dscanArray as $scanResult) {
            // Upwell structures on grid only ...
            if($scanResult['shipClass']->category_id === 65 && $scanResult['dscanData']['3'] !== '-') {
                $dscanRangeArray = \explode(' ', $scanResult['dscanData']['3']);
                $range = (int) \number_format((float) \str_replace('.', '', $dscanRangeArray['0']), 0, '', '');

                /**
                 * Only if the Upwell structure is actually within our defined grid range
                 * Since Upwell structures that are accessable by the pilot
                 * always have a range on d-scans, we need to do it this way ...
                 *
                 * @todo: localized strings for 'km' or 'm'
                 */
                if($range <= $gridSize && \preg_match('/km|m/', $dscanRangeArray['1'])) {
                    if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
                        $count[\sanitize_title($scanResult['shipData']->name)] = 0;
                    }

                    $count[\sanitize_title($scanResult['shipData']->name)] ++;

                    $shipTypeArray[\sanitize_title($scanResult['shipData']->name)] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->name)]);
                }
            }
        }

        \ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Getting deployables that are on grid
     *
     * @param array $dscanArray
     * @return array
     */
    public function getDeployablesArray(array $dscanArray) {
        $shipTypeArray = [];
        $count = [];

        foreach($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if($scanResult['shipClass']->category_id === 22 && $scanResult['dscanData']['3'] !== '-') {
                if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
                    $count[\sanitize_title($scanResult['shipData']->name)] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->name)] ++;

                $shipTypeArray[\sanitize_title($scanResult['shipData']->name)] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->name)]);
            }
        }

        \ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Getting lootable and salvagable item sfrom d-scan
     *
     * @param array $dscanArray
     * @return array
     */
    public function getLootSalvageArray(array $dscanArray) {
        $lootSalvageArray = [];
        $count = [];
        $exclude = [
            'Biomass'
        ];

        foreach($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if($scanResult['shipClass']->category_id === 2 && $scanResult['dscanData']['3'] !== '-' && !\in_array($scanResult['shipClass']->name, $exclude)) {
                if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
                    $count[\sanitize_title($scanResult['shipData']->name)] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->name)] ++;

                $lootSalvageArray[\sanitize_title($scanResult['shipData']->name)] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->name)]);
            }
        }

        \ksort($lootSalvageArray);

        return $lootSalvageArray;
    }

    /**
     * Getting starbase modules from d-scan
     *
     * @param array $dscanArray
     * @return array
     */
    public function getStarbaseArray(array $dscanArray) {
        $starbaseArray = [];
        $count = [];

        foreach($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if($scanResult['shipClass']->category_id === 23 && $scanResult['dscanData']['3'] !== '-') {
                if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
                    $count[\sanitize_title($scanResult['shipData']->name)] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->name)] ++;

                $starbaseArray[\sanitize_title($scanResult['shipData']->name)] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->name)]);
            }
        }

        \ksort($starbaseArray);

        return $starbaseArray;
    }

    /**
     * Get the result for one d-scan line
     *
     * @param array $scanResult
     * @param int $count
     * @return array
     */
    private function getScanResultDetails(array $scanResult, int $count) {
        return [
            'type' => $scanResult['shipData']->name,
            'type_id' => $scanResult['shipData']->type_id,
            'shipTypeSanitized' => \sanitize_title($scanResult['shipData']->name),
            'count' => $count
        ];
    }
}
