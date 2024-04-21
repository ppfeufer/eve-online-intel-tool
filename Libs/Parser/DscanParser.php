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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\DotlanHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StructureHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

class DscanParser extends AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var EsiHelper
     */
    private EsiHelper $esiHelper;

    /**
     * Dotlan Helper
     *
     * @var DotlanHelper
     */
    private DotlanHelper $dotlanHelper;

    /**
     * String Helper
     *
     * @var StringHelper
     */
    private StringHelper $stringHelper;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esiHelper = EsiHelper::getInstance();
        $this->stringHelper = StringHelper::getInstance();
        $this->dotlanHelper = DotlanHelper::getInstance();
    }

    /**
     * Parsing the D-Scan
     *
     * @param string $scanData
     * @return array|null
     */
    public function parseDscan(string $scanData): ?array {
        $returnData = null;

        $dscanArray = $this->getDscanArray(scanData: $scanData);
        if ($dscanArray['all']['count'] !== 0) {
            $dscanAll = $this->parseScanArray(dscanArray: $dscanArray['all']);
            $returnData['all'] = $dscanAll;

            $returnData['shipTypes'] = $this->getShipTypesArray(dscanArray: $dscanArray['all']['data']);
            $returnData['upwellStructures'] = $this->getUpwellStructuresArray(dscanArray: $dscanArray['all']['data']);
            $returnData['deployables'] = $this->getDeployablesArray(dscanArray: $dscanArray['all']['data']);
            $returnData['miscellaneous'] = $this->getMiscellaneousArray(dscanArray: $dscanArray['all']['data']);
            $returnData['starbaseModules'] = $this->getStarbaseArray(dscanArray: $dscanArray['all']['data']);
            $returnData['lootSalvage'] = $this->getLootSalvageArray(dscanArray: $dscanArray['all']['data']);
        }

        if ($dscanArray['onGrid']['count'] !== 0) {
            $dscanOnGrid = $this->parseScanArray(dscanArray: $dscanArray['onGrid']);
            $returnData['onGrid'] = $dscanOnGrid;
        }

        if ($dscanArray['offGrid']['count'] !== 0) {
            $dscanOffGrid = $this->parseScanArray(dscanArray: $dscanArray['offGrid']);
            $returnData['offGrid'] = $dscanOffGrid;
        }

        $returnData['systemInformation'] = $dscanArray['system'];

        return $returnData;
    }

    /**
     * Breaking down the D-Scan into arrays
     *
     * @param string $scanData
     * @return array
     */
    public function getDscanArray(string $scanData): array {
        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = $this->stringHelper->fixLineBreaks(scanData: $scanData);

        $dscanDetailShipsAll = [];
        $dscanDetailShipsOnGrid = [];
        $dscanDetailShipsOffGrid = [];
        $shipData = [];

        foreach (explode(separator: "\n", string: trim(string: $cleanedScanData)) as $line) {
            $lineDetailsArray = explode(separator: "\t", string: str_replace(search: '*', replace: '', subject: trim(string: $line)));

            if (!isset($shipData[$lineDetailsArray['0']])) {
                $shipData[$lineDetailsArray['0']] = $this->esiHelper->getShipData(shipId: $lineDetailsArray['0']);
            }

            if (!is_null(value: $shipData[$lineDetailsArray['0']]['shipData']) && !is_null(value: $shipData[$lineDetailsArray['0']]['shipTypeData'])) {
                $dscanDetailShipsAll[] = [
                    'dscanData' => $lineDetailsArray,
                    'shipData' => $shipData[$lineDetailsArray['0']]['shipData'],
                    'shipClass' => $shipData[$lineDetailsArray['0']]['shipTypeData']
                ];

                /**
                 * Determine OnGrid and OffGrid
                 */
                if ($lineDetailsArray['3'] === '-') {
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

        // Let's see if we can find out in what system we are …
        $system = $this->detectSystem(cleanedScanData: $cleanedScanData);

        return [
            'all' => [
                'count' => count($dscanDetailShipsAll),
                'data' => $dscanDetailShipsAll
            ],
            'onGrid' => [
                'count' => count($dscanDetailShipsOnGrid),
                'data' => $dscanDetailShipsOnGrid
            ],
            'offGrid' => [
                'count' => count($dscanDetailShipsOffGrid),
                'data' => $dscanDetailShipsOffGrid
            ],
            'system' => $system
        ];
    }

    /**
     * Try and detect the system the scan was made in
     *
     * @param string $cleanedScanData
     * @return array|null
     */
    public function detectSystem(string $cleanedScanData): ?array {
        $returnValue = null;

        /**
         * Trying to find the system by one of the structure IDs
         */
        $systemInfo = $this->detectSystemByUpwellStructure(scandata: $cleanedScanData);

        /**
         * Determine system by its sun if we couldn't get
         * a system from an Upwell structure
         */
        if ($systemInfo['systemFound'] === false) {
            $systemInfo = $this->detectSystemBySun(scandata: $cleanedScanData);
        }

        /**
         * If we have a system name, get the system data,
         * like constellation and region
         */
        if ($systemInfo['systemName'] !== null) {
            $returnValue = $this->getSystemInformationBySystemName(systemName: $systemInfo['systemName']);
        }

        return $returnValue;
    }

    /**
     * Detecting the system by Upwell structures on d-scan
     *
     * @param string $scandata
     * @return array|null
     */
    public function detectSystemByUpwellStructure(string $scandata): ?array {
        $systemFound = false;
        $systemName = null;

        $upwellStructureIds = StructureHelper::getInstance()->getUpwellStructureIds();

        foreach (explode(separator: "\n", string: trim(string: $scandata)) as $line) {
            $lineDetailsArray = explode(separator: "\t", string: str_replace(search: '*', replace: '', subject: trim(string: $line)));

            if (in_array(needle: (int)$lineDetailsArray['0'], haystack: $upwellStructureIds)) {
                $parts = explode(separator: ' - ', string: $lineDetailsArray['1']);

                /**
                 * Fix for Ansiblex Jump Gate, since
                 * they can have 2 systems in their names
                 */
                if ((int)$lineDetailsArray['0'] === 35841 && str_contains(haystack: $lineDetailsArray['1'], needle: '»')) {
                    $parts = explode(separator: ' » ', string: $lineDetailsArray['1']);
                }

                $systemName = trim(string: $parts['0']);

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
     * @return array|null
     */
    public function detectSystemBySun(string $scandata): ?array {
        $systemName = null;
        $systemFound = false;

        foreach (explode(separator: "\n", string: trim(string: $scandata)) as $line) {
            $lineDetailsArray = explode(separator: "\t", string: str_replace(search: '*', replace: '', subject: trim($line)));

            if (preg_match(pattern: '/(.*) - Star/', subject: $lineDetailsArray['1']) && preg_match(pattern: '/Sun (.*)/', subject: $lineDetailsArray['2'])) {
                $systemName = trim(str_replace(search: ' - Star', replace: '', subject: $lineDetailsArray['1']));
                $systemFound = true;
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
     * @return array|null
     */
    public function getSystemInformationBySystemName(string $systemName): ?array {
        $returnValue = null;
        $systemShortData = $this->esiHelper->getIdFromName(names: [trim(string: $systemName)], type: 'systems');

        if (!is_null(value: $systemShortData)) {
            /* @var $systemData \WordPress\EsiClient\Model\Universe\Systems\SystemId */
            $systemData = $this->esiHelper->getSystemData(systemId: $systemShortData['0']->getId());
            $systemId = $systemData->getSystemId();
            $constellationName = null;
            $regionName = null;

            // Get the constellation data
            /* @var $constellationData \WordPress\EsiClient\Model\Universe\Constellations\ConstellationId */
            $constellationData = $this->esiHelper->getConstellationData(constellationId: $systemData->getConstellationId());

            // Set the constellation name
            if (!is_null($constellationData)) {
                $constellationName = $constellationData->getName();
                $constellationId = $constellationData->getConstellationId();

                // Get the region data
                /* @var $regionData \WordPress\EsiClient\Model\Universe\Regions\RegionId */
                $regionData = $this->esiHelper->getRegionsRegionId(regionId: $constellationData->getRegionId());

                // Set the region name
                if (!is_null($regionData)) {
                    $regionName = $regionData->getName();
                    $regionId = $regionData->getRegionId();
                }
            }

            /* @var $mapData \WordPress\EsiClient\Model\Sovereignty\Map */
            $mapData = $this->esiHelper->getSovereigntyMap();

            $sovHolder = null;

            if (is_a(object_or_class: $mapData, class: '\WordPress\EsiClient\Model\Sovereignty\Map')) {
                foreach ($mapData->getSolarSystems() as $systemSovereigntyInformation) {
                    /* @var $systemSovereigntyInformation \WordPress\EsiClient\Model\Sovereignty\Sovereignty\Map\Systems */
                    if (!is_null(value: $systemSovereigntyInformation->getAllianceId())
                        && ($systemSovereigntyInformation->getSystemId() === $systemData->getSystemId())
                    ) {
                        $sovHoldingAlliance = $this->esiHelper->getAllianceData(allianceId: $systemSovereigntyInformation->getAllianceId());
                        $sovHoldingCorporation = $this->esiHelper->getCorporationData(corporationId: $systemSovereigntyInformation->getCorporationId());

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
            foreach ($systemJumpsData as $systemJumps) {
                /* @var $systemJumps \WordPress\EsiClient\Model\Universe\SystemJumps */
                if ($systemJumps->getSystemId() === $systemData->getSystemId()) {
                    $systemActivity['jumps'] = $systemJumps->getShipJumps();
                }
            }

            $systemKillsData = $this->esiHelper->getSystemKills();
            foreach ($systemKillsData as $systemKills) {
                /* @var $systemKills \WordPress\EsiClient\Model\Universe\SystemKills */
                if ($systemKills->getSystemId() === $systemData->getSystemId()) {
                    $systemActivity['npcKills'] = $systemKills->getNpcKills();
                    $systemActivity['podKills'] = $systemKills->getPodKills();
                    $systemActivity['shipKills'] = $systemKills->getShipKills();
                }
            }

            /**
             * Get system status
             */
            $systemSecurityStatus = number_format(num: $systemData->getSecurityStatus(), decimals: 1);
            $systemAdm = null;

            $systemStructuresData = $this->esiHelper->getSovereigntyStryuctures();
            foreach ($systemStructuresData as $structureData) {
                if ($structureData->getSolarSystemId() === $systemData->getSystemId()) {
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
     * @return array|null
     */
    public function parseScanArray(array $dscanArray): ?array {
        $returnData = null;
        $dscanDetails = [];
        $count = [];
        $shipCounter = 0;

        foreach ($dscanArray['data'] as $item) {
            if ($item['shipClass']->getCategoryId() === 6) {
                /**
                 * Counter for Ship Types
                 */
                $count[$item['dscanData']['0']]['all'][] = '';
                $dscanDetails['count'] = ++$shipCounter;

                /**
                 * Ship breakdown
                 */
                $dscanDetails['data'][sanitize_title((string)$item['dscanData']['2'])]['shipID'] = $item['dscanData']['0'];
                $dscanDetails['data'][sanitize_title((string)$item['dscanData']['2'])]['shipName'] = $item['dscanData']['2'];
                $dscanDetails['data'][sanitize_title((string)$item['dscanData']['2'])]['count'] = count($count[$item['dscanData']['0']]['all']);
                $dscanDetails['data'][sanitize_title((string)$item['dscanData']['2'])]['shipClass'] = $item['shipClass']->getName();
                $dscanDetails['data'][sanitize_title((string)$item['dscanData']['2'])]['shipTypeSanitized'] = sanitize_title((string)$item['shipClass']->getName());
            }
        }

        if (!empty($dscanDetails['data'])) {
            ksort(array: $dscanDetails['data']);

            $returnData = $dscanDetails;
        }

        return $returnData;
    }

    /**
     * Getting the shiptypes array
     *
     * @param array $dscanArray
     * @return array
     */
    public function getShipTypesArray(array $dscanArray): array {
        $shipTypeArray = [];
        $count = [];

        foreach ($dscanArray as $scanResult) {
            // Ships only ...
            if ($scanResult['shipClass']->getcategoryId() === 6) {
                if (!isset($count[sanitize_title(title: $scanResult['shipClass']->getName())])) {
                    $count[sanitize_title(title: $scanResult['shipClass']->getName())] = 0;
                }

                $count[sanitize_title(title: $scanResult['shipClass']->getName())]++;

                $shipTypeArray[sanitize_title(title: $scanResult['shipClass']->getName())] = [
                    'type' => $scanResult['shipClass']->getName(),
                    'shipTypeSanitized' => sanitize_title(title: $scanResult['shipClass']->getName()),
                    'count' => $count[sanitize_title(title: $scanResult['shipClass']->getName())]
                ];
            }
        }

        ksort(array: $shipTypeArray);

        return $shipTypeArray;
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
    public function getUpwellStructuresArray(array $dscanArray): array {
        $shipTypeArray = [];
        $count = [];

        foreach ($dscanArray as $scanResult) {
            // Upwell structures on grid only ...
            if (($scanResult['shipClass']->getCategoryId() === 65) && ($this->isOnGrid(scanResult: $scanResult) === true)) {
                $shipTypeArray = $this->getTypeArray(count: $count, scanResult: $scanResult, shipTypeArray: $shipTypeArray);
            }
        }

        ksort(array: $shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Determine is seomthing is on grid or not
     *
     * @param array $scanResult
     * @return boolean
     */
    private function isOnGrid(array $scanResult): bool {
        $returnValue = false;
        $gridSize = 10000; // our defined grid size in km
        $dscanRangeArray = explode(separator: ' ', string: $scanResult['dscanData']['3']);
        $range = (int)number_format(
            num: (float)str_replace(search: '.', replace: '', subject: $dscanRangeArray['0']),
            decimal_separator: '',
            thousands_separator: ''
        );

        if (($scanResult['dscanData']['3'] !== '-')
            && ($range <= $gridSize && preg_match(
                pattern: '/km|m/',
                subject: $dscanRangeArray['1']
            ))
        ) {
            $returnValue = true;
        }

        return $returnValue;
    }

    /**
     * Get type array
     *
     * @param array $count
     * @param $scanResult
     * @param array $shipTypeArray
     * @return array
     */
    protected function getTypeArray(array $count, $scanResult, array $shipTypeArray): array {
        if (!isset($count[sanitize_title(title: $scanResult['shipData']->getName())])) {
            $count[sanitize_title(title: $scanResult['shipData']->getName())] = 0;
        }

        $count[sanitize_title(title: $scanResult['shipData']->getName())]++;
        $shipTypeArray[sanitize_title(title: $scanResult['shipData']->getName())] = $this->getScanResultDetails(
            scanResult: $scanResult,
            count: $count[sanitize_title(title: $scanResult['shipData']->getName())]
        );

        return $shipTypeArray;
    }

    /**
     * Get the result for one d-scan line
     *
     * @param array $scanResult
     * @param int $count
     * @return array
     */
    private function getScanResultDetails(array $scanResult, int $count): array {
        return [
            'type' => ($scanResult['shipData']->getTypeId() === 35841)
                ? $scanResult['shipData']->getName() . $this->getAnsiblexJumGateDestination(scanResult: $scanResult)
                : $scanResult['shipData']->getName(),
            'imageAlt' => ($scanResult['shipData']->getTypeId() === 35841)
                ? $scanResult['shipData']->getName() . $this->getAnsiblexJumGateDestination(scanResult: $scanResult, linkDestination: false)
                : $scanResult['shipData']->getName(),
            'type_id' => $scanResult['shipData']->getTypeId(),
            'shipTypeSanitized' => sanitize_title(title: $scanResult['shipData']->getName()),
            'count' => $count
        ];
    }

    /**
     * Getting the destination system of an Ansiblex Jump Gate
     *
     * @param array $scanResult
     * @param bool $linkDestination
     * @return string|null
     */
    private function getAnsiblexJumGateDestination(array $scanResult, bool $linkDestination = true): ?string {
        $returnValue = null;

        $dscanData = $scanResult['dscanData'];
        $ansiblexJumpGateName = $dscanData['1'];
        $nameParts = explode(separator: ' - ', string: $ansiblexJumpGateName);

        if (str_contains(haystack: $nameParts['0'], needle: '»')) {
            $gateSystems = explode(separator: ' » ', string: $nameParts['0']);
            $destinationSystem = trim($gateSystems['1']);

            // get system information so we can link it to Dotlan
            if ((!empty($destinationSystem)) && ($linkDestination === true)) {
                /* @var $destinationSystemId \WordPress\EsiClient\Model\Universe\Ids\Systems */
                $destinationSystemId = $this->esiHelper->getIdFromName(
                    names: [$destinationSystem],
                    type: 'systems'
                );
                $destinationSystemData = $this->esiHelper->getSystemData(
                    systemId: $destinationSystemId['0']->getId()
                );
                $destinationSystemContellationData = $this->esiHelper->getConstellationData(
                    constellationId: $destinationSystemData->getConstellationId()
                );
                $destinationSystemRegionData = $this->esiHelper->getRegionsRegionId(
                    regionId: $destinationSystemContellationData->getRegionId()
                );

                $destinationSystem = '<a href="https://evemaps.dotlan.net/map/' . $this->dotlanHelper->getDotlanLinkString(string: $destinationSystemRegionData->getName() . '/' . $destinationSystem) . '" target="_blank" rel="noopener noreferer" class="eve-intel-information-link">' . $destinationSystem . '</a>';

                $returnValue = ' » ' . $destinationSystem;

            }
        }

        return $returnValue;
    }

    /**
     * Getting deployables that are on grid
     *
     * @param array $dscanArray
     * @return array
     */
    public function getDeployablesArray(array $dscanArray): array {
        $shipTypeArray = [];
        $count = [];

        foreach ($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if (($scanResult['shipClass']->getCategoryId() === 22) && ($this->isOnGrid(scanResult: $scanResult) === true)) {
                $shipTypeArray = $this->getTypeArray(count: $count, scanResult: $scanResult, shipTypeArray: $shipTypeArray);
            }
        }

        ksort($shipTypeArray);

        return $shipTypeArray;
    }

    /**
     * Getting miscellaneous items that are on grid
     * like scanner probes and so on
     *
     * @param array $dscanArray
     * @return array
     */
    public function getMiscellaneousArray(array $dscanArray): array {
        $miscellaneousTypeArray = [];
        $count = [];
        $miscellaneousGroupIds = [
            479 // Scanner Probes
        ];

        foreach ($dscanArray as $scanResult) {
            // Miscellaneous items on grid only ...
            if (($this->isOnGrid(scanResult: $scanResult) === true)
                && in_array(
                    needle: $scanResult['shipClass']->getGroupId(),
                    haystack: $miscellaneousGroupIds,
                    strict: true
                )
            ) {
                $miscellaneousTypeArray = $this->getTypeArray(count: $count, scanResult: $scanResult, shipTypeArray: $miscellaneousTypeArray);
            }
        }

        ksort(array: $miscellaneousTypeArray);

        return $miscellaneousTypeArray;
    }

    /**
     * Getting starbase modules from d-scan
     *
     * @param array $dscanArray
     * @return array
     */
    public function getStarbaseArray(array $dscanArray): array {
        $starbaseArray = [];
        $count = [];

        foreach ($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if ($scanResult['dscanData']['3'] !== '-'
                && $scanResult['shipClass']->getCategoryId() === 23
            ) {
                $starbaseArray = $this->getTypeArray(
                    count: $count,
                    scanResult: $scanResult,
                    shipTypeArray: $starbaseArray
                );
            }
        }

        ksort(array: $starbaseArray);

        return $starbaseArray;
    }

    /**
     * Getting lootable and salvagable item sfrom d-scan
     *
     * @param array $dscanArray
     * @return array
     */
    public function getLootSalvageArray(array $dscanArray): array {
        $lootSalvageArray = [];
        $count = [];
        $exclude = [
            'Biomass'
        ];

        foreach ($dscanArray as $scanResult) {
            // Deployable structures on grid only ...
            if ($scanResult['dscanData']['3'] !== '-'
                && $scanResult['shipClass']->getCategoryId() === 2 &&
                !in_array(
                    needle: $scanResult['shipClass']->getName(),
                    haystack: $exclude,
                    strict: true
                )
            ) {
                $lootSalvageArray = $this->getTypeArray(
                    count: $count,
                    scanResult: $scanResult,
                    shipTypeArray: $lootSalvageArray
                );
            }
        }

        ksort(array: $lootSalvageArray);

        return $lootSalvageArray;
    }
}
