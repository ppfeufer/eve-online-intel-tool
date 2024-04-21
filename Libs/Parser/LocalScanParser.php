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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

class LocalScanParser extends AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var EsiHelper
     */
    protected EsiHelper $esiHelper;

    /**
     * String Helper
     *
     * @var StringHelper
     */
    protected StringHelper $stringHelper;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esiHelper = EsiHelper::getInstance();
        $this->stringHelper = StringHelper::getInstance();
    }

    public function parseLocalScan(string $scanData): ?array {
        $returnValue = null;
        $localArray = $this->getLocalArray(scanData: $scanData);

        if (!is_null($localArray)) {
            $participationData = $this->getParticipation(pilotDetails: $localArray['pilotDetails']);

            $returnValue = [
                'rawData' => $scanData,
                'pilotDetails' => $localArray['pilotDetails'] ?? null,
                'characterList' => $localArray['pilotList'] ?? null,
                'corporationList' => $participationData['corporationList'] ?? null,
                'allianceList' => $participationData['allianceList'] ?? null,
                'corporationParticipation' => $participationData['corporationParticipation'] ?? null,
                'allianceParticipation' => $participationData['allianceParticipation'] ?? null,
            ];
        }

        return $returnValue;
    }

    /**
     * Parsing the scan data and get an array with every pilots data
     *
     * @param string $scanData
     * @return array|null
     */
    public function getLocalArray(string $scanData): ?array {
        $returnValue = null;

        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = $this->stringHelper->fixLineBreaks(scanData: $scanData);

        $pilotList = [];
        $pilotDetails = [];
        $arrayCharacterIds = [];
        $characterIdChunkSize = 250;
        $scanDataArraySanitized = [];
        $corporationSheet = [];

        $scanDataArray = explode(separator: "\n", string: trim(string: $cleanedScanData));

        // making sure we don't have any multiples
        foreach ($scanDataArray as $line) {
            $scanDataArraySanitized[trim(string: $line)] = $line;
        }

        // running ESI in chunks to get the IDs to the names
        foreach (array_chunk(array: $scanDataArraySanitized, length: $characterIdChunkSize, preserve_keys: true) as $nameSet) {
            $esiData = $this->esiHelper->getIdFromName(names: $nameSet, type: 'characters');

            if (!is_null(value: $esiData)) {
                $nameToIdSet = [];

                foreach ($esiData as $characterData) {
                    /* @var $characterData \WordPress\EsiClient\Model\Universe\Ids\Characters */
                    $nameToIdSet[] = $characterData->getId();
                    $pilotList[$characterData->getId()] = $characterData->getName();
                }

                $characterAffiliationData = $this->esiHelper->getCharacterAffiliation(characterIds: $nameToIdSet);

                foreach ($characterAffiliationData as $characterAffiliatedIds) {
                    if (is_a(object_or_class: $characterAffiliatedIds, class: '\WordPress\EsiClient\Model\Characters\Affiliation\Characters')) {
                        /* @var $characterAffiliatedIds \WordPress\EsiClient\Model\Characters\Affiliation\Characters */
                        $pilotDetails[$characterAffiliatedIds->getCharacterId()] = [
                            'characterID' => $characterAffiliatedIds->getCharacterId(),
                            'characterName' => $pilotList[$characterAffiliatedIds->getCharacterId()]
                        ];

                        /**
                         * Grabbing corporation information
                         */
                        if (!is_null($characterAffiliatedIds->getCorporationId())) {
                            if (!isset($corporationSheet[$characterAffiliatedIds->getCorporationId()])) {
                                $corporationSheet[$characterAffiliatedIds->getCorporationId()] = $this->esiHelper->getCorporationData(
                                    corporationId: $characterAffiliatedIds->getCorporationId()
                                );
                            }

                            if (!is_null(value: $corporationSheet[$characterAffiliatedIds->getCorporationId()])) {
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationID'] = $characterAffiliatedIds->getCorporationId();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationName'] = $corporationSheet[$characterAffiliatedIds->getCorporationId()]->getName();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationTicker'] = $corporationSheet[$characterAffiliatedIds->getCorporationId()]->getTicker();
                            }
                        }

                        /**
                         * Grabbing alliance information
                         */
                        $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceID'] = null;
                        $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceName'] = null;
                        $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceTicker'] = null;

                        if (!is_null(value: $characterAffiliatedIds->getAllianceId())) {
                            /* @var $allianceSheet \WordPress\EsiClient\Model\Alliances\AllianceId */
                            $allianceSheet = $this->esiHelper->getAllianceData(allianceId: $characterAffiliatedIds->getAllianceId());

                            if (!is_null($allianceSheet)) {
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceID'] = $characterAffiliatedIds->getAllianceId();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceName'] = $allianceSheet->getName();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceTicker'] = $allianceSheet->getTicker();
                            }
                        }
                    }
                }
            }
        }

        if (count($pilotDetails) > 0) {
            $returnValue = [
                'pilotList' => $pilotList,
                'pilotDetails' => $pilotDetails
            ];
        }

        return $returnValue;
    }

    /**
     * Getting the corporation and alliances involved
     *
     * @param array $pilotDetails
     * @return array|null
     */
    public function getParticipation(array $pilotDetails): ?array {
        $returnValue = null;
        $employementList = [];
        $corporationList = [];
        $corporationParticipation = [];
        $allianceList = [];
        $allianceParticipation = [];
        $counter = [];

        foreach ($pilotDetails as $pilotSheet) {
            /**
             * Corporation list
             */
            if (isset($pilotSheet['corporationID'])) {
                if (!isset($counter[sanitize_title(title: $pilotSheet['corporationName'])])) {
                    $counter[sanitize_title(title: $pilotSheet['corporationName'])] = 0;
                }

                $counter[sanitize_title(title: $pilotSheet['corporationName'])]++;

                $corporationList[sanitize_title(title: $pilotSheet['corporationName'])] = [
                    'corporationID' => $pilotSheet['corporationID'],
                    'corporationName' => $pilotSheet['corporationName'],
                    'corporationTicker' => $pilotSheet['corporationTicker'],

                    'allianceID' => $pilotSheet['allianceID'] ?? 0,
                    'allianceName' => $pilotSheet['allianceName'] ?? null,
                    'allianceTicker' => $pilotSheet['allianceTicker'] ?? null
                ];

                $corporationParticipation[sanitize_title(title: $pilotSheet['corporationName'])] = [
                    'count' => $counter[sanitize_title(title: $pilotSheet['corporationName'])],
                    'corporationID' => $pilotSheet['corporationID'],
                    'corporationName' => $pilotSheet['corporationName'],
                    'corporationTicker' => $pilotSheet['corporationTicker'],

                    'allianceID' => $pilotSheet['allianceID'] ?? 0,
                    'allianceName' => $pilotSheet['allianceName'] ?? null,
                    'allianceTicker' => $pilotSheet['allianceTicker'] ?? null
                ];
            }

            /**
             * Alliance List
             */
            if (isset($pilotSheet['allianceID'])) {
                if (!isset($counter[sanitize_title(title: $pilotSheet['allianceName'])])) {
                    $counter[sanitize_title(title: $pilotSheet['allianceName'])] = 0;
                }

                $counter[sanitize_title(title: $pilotSheet['allianceName'])]++;

                $allianceList[sanitize_title(title: $pilotSheet['allianceName'])] = [
                    'allianceID' => $pilotSheet['allianceID'],
                    'allianceName' => $pilotSheet['allianceName'],
                    'allianceTicker' => $pilotSheet['allianceTicker']
                ];

                $allianceParticipation[sanitize_title(title: $pilotSheet['allianceName'])] = [
                    'count' => $counter[sanitize_title(title: $pilotSheet['allianceName'])],
                    'allianceID' => $pilotSheet['allianceID'],
                    'allianceName' => $pilotSheet['allianceName'],
                    'allianceTicker' => $pilotSheet['allianceTicker']
                ];
            }

            /**
             * Unaffiliated pilots with no alliance
             */
            if (!isset($pilotSheet['allianceID'])) {
                if (!isset($counter[sanitize_title(title: 'Unaffiliated / No Alliance')])) {
                    $counter[sanitize_title(title: 'Unaffiliated / No Alliance')] = 0;
                }

                $counter[sanitize_title(title: 'Unaffiliated / No Alliance')]++;

                $allianceList[sanitize_title(title: 'Unaffiliated / No Alliance')] = [
                    'allianceID' => 0,
                    'allianceName' => __('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
                    'allianceTicker' => null
                ];

                $allianceParticipation[sanitize_title(title: 'Unaffiliated / No Alliance')] = [
                    'count' => $counter[sanitize_title(title: 'Unaffiliated / No Alliance')],
                    'allianceID' => 0,
                    'allianceName' => __('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
                    'allianceTicker' => null
                ];
            }
        }

        ksort(array: $corporationList);
        ksort(array: $corporationParticipation);
        ksort(array: $allianceList);
        ksort(array: $allianceParticipation);

        /**
         * Sorting corporations
         */
        $employementList['corporationList'] = $corporationList;

        foreach ($corporationParticipation as $corporation) {
            $employementList['corporationParticipation'][$corporation['count']][sanitize_title(title: $corporation['corporationName'])] = $corporation;
        }

        /**
         * Sorting alliances
         */
        $employementList['allianceList'] = $allianceList;

        foreach ($allianceParticipation as $alliance) {
            $employementList['allianceParticipation'][$alliance['count']][sanitize_title(title: $alliance['allianceName'])] = $alliance;
        }

        krsort(array: $employementList['corporationParticipation']);
        krsort(array: $employementList['allianceParticipation']);

        if (count($employementList) > 0) {
            $returnValue = $employementList;
        }

        unset($counter);

        return $returnValue;
    }
}
