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

\defined('ABSPATH') or die();

class LocalScanParser extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper
     */
    private $esiHelper = null;

    /**
     * String Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper
     */
    private $stringHelper = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esiHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
        $this->stringHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper::getInstance();
    }

    public function parseLocalScan($scanData) {
        $returnValue = null;
        $localArray = $this->getLocalArray($scanData);

        if(!\is_null($localArray)) {
            $employementData = $this->getParticipation($localArray['pilotDetails']);

            $returnValue = [
                'rawData' => $scanData,
                'pilotDetails' => (!\is_null($localArray)) ? $localArray['pilotDetails'] : null,
                'characterList' => (!\is_null($localArray)) ? $localArray['pilotList'] : null,
                'corporationList' => (!\is_null($employementData)) ? $employementData['corporationList'] : null,
                'allianceList' => (!\is_null($employementData)) ? $employementData['allianceList'] : null,
                'corporationParticipation' => (!\is_null($employementData)) ? $employementData['corporationParticipation'] : null,
                'allianceParticipation' => (!\is_null($employementData)) ? $employementData['allianceParticipation'] : null
            ];
        }

        return $returnValue;
    }

    /**
     * Parsing the scan data and get an array with every pilots data
     *
     * @param string $scanData
     * @return array
     */
    public function getLocalArray($scanData) {
        $returnValue = null;

        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = $this->stringHelper->fixLineBreaks($scanData);

        $pilotList = [];
        $pilotDetails = [];
        $arrayCharacterIds = [];
        $characterIdChunkSize = 250;
        $scanDataArraySanitized = [];

        $scanDataArray = \explode("\n", \trim($cleanedScanData));

        // making sure we don't have any multiples
        foreach($scanDataArray as $line) {
            if(!isset($arrayCharacterIds[\trim($line)])) {
                $scanDataArraySanitized[\trim($line)] = $line;
            }
        }

        // running ESI in chunks to get the IDs to the names
        foreach(\array_chunk($scanDataArraySanitized, $characterIdChunkSize, true) as $nameSet) {
            $esiData = $this->esiHelper->getIdFromName($nameSet, 'characters');

            if(!\is_null($esiData)) {
                $nameToIdSet = null;

                foreach($esiData as $characterData) {
                    /* @var $characterData \WordPress\EsiClient\Model\Universe\UniverseIds\Character */
                    $nameToIdSet[] = $characterData->getId();
                    $pilotList[$characterData->getId()] = $characterData->getName();
                }

                $characterAffiliationData = $this->esiHelper->getCharacterAffiliation($nameToIdSet);
                foreach($characterAffiliationData as $affiliatedIds) {
                    /* @var $affiliatedIds \WordPress\EsiClient\Model\Character\CharactersAffiliation */
                    $pilotDetails[$affiliatedIds->getCharacterId()] = [
                        'characterID' => $affiliatedIds->getCharacterId(),
                        'characterName' => $pilotList[$affiliatedIds->getCharacterId()]
                    ];

                    /**
                     * Grabbing corporation information
                     */
                    if(!\is_null($affiliatedIds->getCorporationId())) {
                        /* @var $corporationSheet \WordPress\EsiClient\Model\Corporation\CorporationsCorporationId */
                        $corporationSheet = $this->esiHelper->getCorporationData($affiliatedIds->getCorporationId());

                        if(!\is_null($corporationSheet)) {
                            $pilotDetails[$affiliatedIds->getCharacterId()]['corporationID'] = $affiliatedIds->getCorporationId();
                            $pilotDetails[$affiliatedIds->getCharacterId()]['corporationName'] = $corporationSheet->getName();
                            $pilotDetails[$affiliatedIds->getCharacterId()]['corporationTicker'] = $corporationSheet->getTicker();
                        }
                    }

                    /**
                     * Grabbing alliance information
                     */
                    if(!\is_null($affiliatedIds->getAllianceId())) {
                        /* @var $allianceSheet \WordPress\EsiClient\Model\Alliance\AlliancesAllianceId */
                        $allianceSheet = $this->esiHelper->getAllianceData($affiliatedIds->getAllianceId());

                        if(!\is_null($allianceSheet)) {
                            $pilotDetails[$affiliatedIds->getCharacterId()]['allianceID'] = $affiliatedIds->getAllianceId();
                            $pilotDetails[$affiliatedIds->getCharacterId()]['allianceName'] = $allianceSheet->getName();
                            $pilotDetails[$affiliatedIds->getCharacterId()]['allianceTicker'] = $allianceSheet->getTicker();
                        }
                    }
                }
            }
        }

        if(\count($pilotDetails) > 0) {
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
     * @return array
     */
    public function getParticipation(array $pilotDetails) {
        $returnValue = null;
        $employementList = [];
        $corporationList = [];
        $corporationParticipation = [];
        $allianceList = [];
        $allianceParticipation = [];
        $counter = [];

        foreach($pilotDetails as $pilotSheet) {
            /**
             * Corporation list
             */
            if(isset($pilotSheet['corporationID'])) {
                if(!isset($counter[\sanitize_title($pilotSheet['corporationName'])])) {
                    $counter[\sanitize_title($pilotSheet['corporationName'])] = 0;
                }

                $counter[\sanitize_title($pilotSheet['corporationName'])] ++;

                $corporationList[\sanitize_title($pilotSheet['corporationName'])] = [
                    'corporationID' => $pilotSheet['corporationID'],
                    'corporationName' => $pilotSheet['corporationName'],
                    'corporationTicker' => $pilotSheet['corporationTicker'],
                    'allianceID' => (isset($pilotSheet['allianceID'])) ? $pilotSheet['allianceID'] : 0,
                    'allianceName' => (isset($pilotSheet['allianceName'])) ? $pilotSheet['allianceName'] : null,
                    'allianceTicker' => (isset($pilotSheet['allianceTicker'])) ? $pilotSheet['allianceTicker'] : null
                ];

                $corporationParticipation[\sanitize_title($pilotSheet['corporationName'])] = [
                    'count' => $counter[\sanitize_title($pilotSheet['corporationName'])],
                    'corporationID' => $pilotSheet['corporationID'],
                    'corporationName' => $pilotSheet['corporationName'],
                    'corporationTicker' => $pilotSheet['corporationTicker'],
                    'allianceID' => (isset($pilotSheet['allianceID'])) ? $pilotSheet['allianceID'] : 0,
                    'allianceName' => (isset($pilotSheet['allianceName'])) ? $pilotSheet['allianceName'] : null,
                    'allianceTicker' => (isset($pilotSheet['allianceTicker'])) ? $pilotSheet['allianceTicker'] : null
                ];
            }

            /**
             * Alliance List
             */
            if(isset($pilotSheet['allianceID'])) {
                if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])])) {
                    $counter[\sanitize_title($pilotSheet['allianceName'])] = 0;
                }

                $counter[\sanitize_title($pilotSheet['allianceName'])] ++;

                $allianceList[\sanitize_title($pilotSheet['allianceName'])] = [
                    'allianceID' => $pilotSheet['allianceID'],
                    'allianceName' => $pilotSheet['allianceName'],
                    'allianceTicker' => $pilotSheet['allianceTicker']
                ];

                $allianceParticipation[\sanitize_title($pilotSheet['allianceName'])] = [
                    'count' => $counter[\sanitize_title($pilotSheet['allianceName'])],
                    'allianceID' => $pilotSheet['allianceID'],
                    'allianceName' => $pilotSheet['allianceName'],
                    'allianceTicker' => $pilotSheet['allianceTicker']
                ];
            }

            /**
             * Unaffiliated pilots with no alliance
             */
            if(!isset($pilotSheet['allianceID'])) {
                if(!isset($counter[\sanitize_title('Unaffiliated / No Alliance')])) {
                    $counter[\sanitize_title('Unaffiliated / No Alliance')] = 0;
                }

                $counter[\sanitize_title('Unaffiliated / No Alliance')] ++;

                $allianceList[\sanitize_title('Unaffiliated / No Alliance')] = [
                    'allianceID' => 0,
                    'allianceName' => \__('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
                    'allianceTicker' => null
                ];

                $allianceParticipation[\sanitize_title('Unaffiliated / No Alliance')] = [
                    'count' => $counter[\sanitize_title('Unaffiliated / No Alliance')],
                    'allianceID' => 0,
                    'allianceName' => \__('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
                    'allianceTicker' => null
                ];
            }
        }

        \ksort($corporationList);
        \ksort($corporationParticipation);
        \ksort($allianceList);
        \ksort($allianceParticipation);

        /**
         * Sorting corporations
         */
        $employementList['corporationList'] = $corporationList;
        foreach($corporationParticipation as $corporation) {
            $employementList['corporationParticipation'][$corporation['count']][\sanitize_title($corporation['corporationName'])] = $corporation;
        }

        /**
         * Sorting alliances
         */
        $employementList['allianceList'] = $allianceList;
        foreach($allianceParticipation as $alliance) {
            $employementList['allianceParticipation'][$alliance['count']][\sanitize_title($alliance['allianceName'])] = $alliance;
        }

        \krsort($employementList['corporationParticipation']);
        \krsort($employementList['allianceParticipation']);

        if(\count($employementList) > 0) {
            $returnValue = $employementList;
        }

        unset($counter);

        return $returnValue;
    }
}
