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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Parser;

use \WordPress\ {
    EsiClient\Model\Universe\UniverseConstellationsConstellationId,
    EsiClient\Model\Universe\UniverseRegionsRegionId,
    EsiClient\Model\Universe\UniverseSystemsSystemId,
    Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper,
    Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper,
    Plugins\EveOnlineIntelTool\Libs\Helper\StructureHelper,
    Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
};

\defined('ABSPATH') or die();

class DscanParser extends AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var EsiHelper
     */
    private $esiHelper = null;

    /**
     * String Helper
     *
     * @var StringHelper
     */
    private $stringHelper = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esiHelper = EsiHelper::getInstance();
        $this->stringHelper = StringHelper::getInstance();
    }

    /**
     * Breaking down the D-Scan into arrays
     *
     * @param string $scanData
     * @return array
     */
    public function getDscanArray(string $scanData) {
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
        $shipData = [];

        foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            if(!isset($shipData[$lineDetailsArray['0']])) {
                $shipData[$lineDetailsArray['0']] = $this->esiHelper->getShipData($lineDetailsArray['0']);
            }

            if(!\is_null($shipData[$lineDetailsArray['0']]['shipData']) && !\is_null($shipData[$lineDetailsArray['0']]['shipTypeData'])) {
                $dscanDetailShipsAll[] = [
                    'dscanData' => $lineDetailsArray,
                    'shipData' => $shipData[$lineDetailsArray['0']]['shipData'],
                    'shipClass' => $shipData[$lineDetailsArray['0']]['shipTypeData']
                ];

                /**
                 * Determine OnGrid and OffGrid
                 */
                if($lineDetailsArray['3'] === '-') {
                    $dscanDetailShipsOffGrid[] = [
                        'dscanData' => $lineDetailsArray,
                        'shipData' => $shipData[$lineDetailsArray['0']]['shipData'],
                        'shipClass' => $shipData[$lineDetailsArray['0']]['shipTypeData']
                    ];
                } else {
                    $dscanDetailShipsOnGrid[] = [
                        'dscanData' => $lineDetailsArray,
                        'shipData' => $shipData[$lineDetailsArray['0']]['shipData'],
                        'shipClass' => $shipData[$lineDetailsArray['0']]['shipTypeData']
                    ];
                }
            }
        }

        unset($shipData);

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
    public function detectSystem(string $cleanedScanData) {
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
    public function detectSystemByUpwellStructure(string $scandata) {
        $systemFound = false;
        $systemName = null;

        $upwellStructureIds = StructureHelper::getInstance()->getUpwellStructureIds();

        foreach(\explode("\n", \trim($scandata)) as $line) {
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            if(\in_array((int) $lineDetailsArray['0'], $upwellStructureIds)) {
                $parts = \explode(' - ', $lineDetailsArray['1']);

                /**
                 * Fix for Ansiblex Jump Gate, since
                 * they can have 2 systems in their names
                 */
                if((int) $lineDetailsArray['0'] === 35841 && \strstr($lineDetailsArray['1'], '»')) {
                    $parts = \explode(' » ', $lineDetailsArray['1']);
                }

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
    public function detectSystemBySun(string $scandata) {
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
     * @param string $systemName
     * @return array
     */
    public function getSystemInformationBySystemName(string $systemName) {
        $returnValue = null;
        $systemShortData = $this->esiHelper->getIdFromName([\trim($systemName)], 'systems');

        if(!\is_null($systemShortData)) {
            /* @var $systemData UniverseSystemsSystemId */
            $systemData = $this->esiHelper->getSystemData($systemShortData['0']->getId());
            $systemId = $systemData->getSystemId();
            $constellationName = null;
            $regionName = null;

            // Get the constellation data
            /* @var $constellationData UniverseConstellationsConstellationId */
            $constellationData = $this->esiHelper->getConstellationData($systemData->getConstellationId());

            // Set the constellation name
            if(!\is_null($constellationData)) {
                $constellationName = $constellationData->getName();
                $constellationId = $constellationData->getConstellationId();

                // Get the region data
                /* @var $regionData UniverseRegionsRegionId */
                $regionData = $this->esiHelper->getRegionsRegionId($constellationData->getRegionId());

                // Set the region name
                if(!\is_null($regionData)) {
                    $regionName = $regionData->getName();
                    $regionId = $regionData->getRegionId();
                }
            }

            /* @var $mapData \WordPress\EsiClient\Model\Sovereignty\SovereigntyMap */
            $mapData = $this->esiHelper->getSovereigntyMap();

            $sovHolder = null;

            if(\is_a($mapData, '\WordPress\EsiClient\Model\Sovereignty\SovereigntyMap')) {
                foreach($mapData->getSolarSystems() as $systemSovereigntyInformation) {
                    /* @var $systemSovereigntyInformation \WordPress\EsiClient\Model\Sovereignty\SovereigntyMap\System */
                    if(($systemSovereigntyInformation->getSystemId() === $systemData->getSystemId()) && !\is_null($systemSovereigntyInformation->getAllianceId())) {
                        $sovHoldingAlliance = $this->esiHelper->getAllianceData($systemSovereigntyInformation->getAllianceId());
                        $sovHoldingCorporation = $this->esiHelper->getCorporationData($systemSovereigntyInformation->getCorporationId());

                        $sovHolder['alliance']['id'] = $systemSovereigntyInformation->getAllianceId();
                        $sovHolder['alliance']['name'] = $sovHoldingAlliance->getName();
                        $sovHolder['alliance']['ticker'] = $sovHoldingAlliance->getTicker();

                        $sovHolder['corporation']['id'] = $systemSovereigntyInformation->getCorporationId();
                        $sovHolder['corporation']['name'] = $sovHoldingCorporation->getName();
                        $sovHolder['corporation']['ticker'] = $sovHoldingCorporation->getTicker();
                    }
                }
            }

            /**
             * Get system activity
             */
            $systemActivity = [
                'jumps' => 0,
                'npcKills' => 0,
                'podKills' => 0,
                'shipKills' => 0
            ];

            $systemJumpsData = $this->esiHelper->getSystemJumps();
            foreach($systemJumpsData as $systemJumps) {
                /* @var $systemJumps \WordPress\EsiClient\Model\Universe\UniverseSystemJumps */
                if($systemJumps->getSystemId() === $systemData->getSystemId()) {
                    $systemActivity['jumps'] = $systemJumps->getShipJumps();
                }
            }

            $systemKillsData = $this->esiHelper->getSystemKills();
            foreach($systemKillsData as $systemKills) {
                /* @var $systemKills \WordPress\EsiClient\Model\Universe\UniverseSystemKills */
                if($systemKills->getSystemId() === $systemData->getSystemId()) {
                    $systemActivity['npcKills'] = $systemKills->getNpcKills();
                    $systemActivity['podKills'] = $systemKills->getPodKills();
                    $systemActivity['shipKills'] = $systemKills->getShipKills();
                }
            }

            /**
             * Get system status
             */
            $systemSecurityStatus = \number_format($systemData->getSecurityStatus(), 1);
            $systemAdm = null;

            $systemStructuresData = $this->esiHelper->getSovereigntyStryuctures();
            foreach($systemStructuresData as $structureData) {
                if($structureData->getSolarSystemId() === $systemData->getSystemId()) {
                    $systemAdm = $structureData->getVulnerabilityOccupancyLevel();
                }
            }

            $returnValue = [
                'system' => [
                    'id' => $systemId,
                    'name' => $systemName,
                    'securityStatus' => $systemSecurityStatus,
                    'adm' => $systemAdm,
                    'sovHolder' => $sovHolder
                ],
                'constellation' => [
                    'id' => $constellationId,
                    'name' => $constellationName
                ],
                'region' => [
                    'id' => $regionId,
                    'name' => $regionName
                ],
                'activity' => $systemActivity
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
            switch($item['shipClass']->getCategoryId()) {
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
                    $countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->getName())]['shipClass'] = (string) $item['shipClass']->getName();
                    $countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->getName())]['counter'][] = '';

                    /**
                     * Ship breakdown
                     */
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipID'] = $item['dscanData']['0'];
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipName'] = $item['dscanData']['2'];
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['count'] = \count($count[$item['dscanData']['0']]['all']);
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipClass'] = $item['shipClass']->getName();
                    $dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipTypeSanitized'] = \sanitize_title((string) $item['shipClass']->getName());
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
    public function parseDscan(string $scanData) {
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
            $returnData['miscellaneous'] = $this->getMiscellaneousArray($dscanArray['all']['data']);
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
        }

        $returnData['systemInformation'] = $dscanArray['system'];

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
            if($scanResult['shipClass']->getcategoryId() === 6) {
                if(!isset($count[\sanitize_title($scanResult['shipClass']->getName())])) {
                    $count[\sanitize_title($scanResult['shipClass']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipClass']->getName())] ++;

                $shipTypeArray[\sanitize_title($scanResult['shipClass']->getName())] = [
                    'type' => $scanResult['shipClass']->getName(),
                    'shipTypeSanitized' => \sanitize_title($scanResult['shipClass']->getName()),
                    'count' => $count[\sanitize_title($scanResult['shipClass']->getName())]
                ];
            }
        }

        \ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Determine is seomthing is on grid or not
     *
     * @param array $scanResult
     * @return boolean
     */
    private function isOnGrid(array $scanResult) {
        $returnValue = false;
        $gridSize = 10000; // our defined grid size in km
        $dscanRangeArray = \explode(' ', $scanResult['dscanData']['3']);
        $range = (int) \number_format((float) \str_replace('.', '', $dscanRangeArray['0']), 0, '', '');

        if(($scanResult['dscanData']['3'] !== '-') && ($range <= $gridSize && \preg_match('/km|m/', $dscanRangeArray['1']))) {
            $returnValue = true;
        }

        return $returnValue;
    }

    /**
     * Getting structures that are on grid
     *
     *  {
     *      "category_id": 65,
     *      "groups": [
     *          1404,   // Engineering Complex
     *          1405,   // Laboratory
     *          1406,   // Refinery
     *          1407,   // Observatory Array
     *          1408,   // Upwell Jump Gate
     *          1409,   // Administration Hub
     *          1410,   // Advertisement Center
     *          1657,   // Citadel
     *          1876,   // ♦ Engineering Complex
     *          1924,   // ♦ Forward Operating Base
     *          2015,   // Upwell Monument
     *          2016,   // Upwell Cyno Jammer
     *          2017    // Upwell Cyno Beacon
     *      ],
     *      "name": "Structure",
     *      "published": true
     *  }
     *
     * @param array $dscanArray
     * @return array
     */
    public function getUpwellStructuresArray(array $dscanArray) {
        $shipTypeArray = [];
        $count = [];

        foreach($dscanArray as $scanResult) {
            // Upwell structures on grid only ...
            if(($scanResult['shipClass']->getCategoryId() === 65) && ($this->isOnGrid($scanResult) === true)) {
                if(!isset($count[\sanitize_title($scanResult['shipData']->getName())])) {
                    $count[\sanitize_title($scanResult['shipData']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->getName())] ++;
                $shipTypeArray[\sanitize_title($scanResult['shipData']->getName())] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->getName())]);
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
            if(($scanResult['shipClass']->getCategoryId() === 22) && ($this->isOnGrid($scanResult) === true)) {
                if(!isset($count[\sanitize_title($scanResult['shipData']->getName())])) {
                    $count[\sanitize_title($scanResult['shipData']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->getName())] ++;
                $shipTypeArray[\sanitize_title($scanResult['shipData']->getName())] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->getName())]);
            }
        }

        \ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Getting miscellaneous items that are on grid
     * like scanner probes and so on
     *
     * @param array $dscanArray
     * @return array
     */
    public function getMiscellaneousArray(array $dscanArray) {
        $miscellaneousTypeArray = [];
        $count = [];
        $miscellaneousGroupIds = [
            479 // Scanner Probes
        ];

        foreach($dscanArray as $scanResult) {
            // Miscellaneous items on grid only ...
            if(\in_array($scanResult['shipClass']->getGroupId(), $miscellaneousGroupIds) && ($this->isOnGrid($scanResult) === true)) {
                if(!isset($count[\sanitize_title($scanResult['shipData']->getName())])) {
                    $count[\sanitize_title($scanResult['shipData']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->getName())] ++;
                $miscellaneousTypeArray[\sanitize_title($scanResult['shipData']->getName())] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->getName())]);
            }
        }

        \ksort($miscellaneousTypeArray);

        return $miscellaneousTypeArray;
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
            if($scanResult['shipClass']->getCategoryId() === 2 && $scanResult['dscanData']['3'] !== '-' && !\in_array($scanResult['shipClass']->getName(), $exclude)) {
                if(!isset($count[\sanitize_title($scanResult['shipData']->getName())])) {
                    $count[\sanitize_title($scanResult['shipData']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->getName())] ++;

                $lootSalvageArray[\sanitize_title($scanResult['shipData']->getName())] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->getName())]);
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
            if($scanResult['shipClass']->getCategoryId() === 23 && $scanResult['dscanData']['3'] !== '-') {
                if(!isset($count[\sanitize_title($scanResult['shipData']->getName())])) {
                    $count[\sanitize_title($scanResult['shipData']->getName())] = 0;
                }

                $count[\sanitize_title($scanResult['shipData']->getName())] ++;

                $starbaseArray[\sanitize_title($scanResult['shipData']->getName())] = $this->getScanResultDetails($scanResult, $count[\sanitize_title($scanResult['shipData']->getName())]);
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
            'type' => ($scanResult['shipData']->getTypeId() === 35841) ? $scanResult['shipData']->getName() . $this->getAnsiblexJumGateDestination($scanResult) : $scanResult['shipData']->getName(),
            'type_id' => $scanResult['shipData']->getTypeId(),
            'shipTypeSanitized' => \sanitize_title($scanResult['shipData']->getName()),
            'count' => $count
        ];
    }

    /**
     * Getting the destination system of an Ansiblex Jump Gate
     *
     * @param array $scanResult
     * @return string
     */
    private function getAnsiblexJumGateDestination(array $scanResult) {
        $returnValue = null;

        $dscanData = $scanResult['dscanData'];
        $ansiblexJumpGateName = $dscanData['1'];
        $nameParts = \explode(' - ', $ansiblexJumpGateName);

        if(\strstr($nameParts['0'], '»')) {
            $gateSystems = \explode(' » ', $nameParts['0']);
            $destinationSystem = \trim($gateSystems['1']);

            if(!empty($destinationSystem)) {
                $returnValue = ' » ' . $destinationSystem;
            }
        }

        return $returnValue;
    }
}
