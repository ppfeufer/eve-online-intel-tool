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

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

\defined('ABSPATH') or die();

class LocalScanParser extends AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var EsiHelper
     */
    protected $esiHelper = null;

    /**
     * String Helper
     *
     * @var StringHelper
     */
    protected $stringHelper = null;

    /**
     * Coalition Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\CoalitionHelper
     */
    protected $coalitionHelper = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esiHelper = EsiHelper::getInstance();
        $this->stringHelper = StringHelper::getInstance();
        $this->coalitionHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\CoalitionHelper::getInstance();
    }

    public function parseLocalScan(string $scanData) {
        $returnValue = null;
        $localArray = $this->getLocalArray($scanData);

        if(!\is_null($localArray)) {
            $participationData = $this->getParticipation($localArray['pilotDetails']);

            $returnValue = [
                'rawData' => $scanData,
                'pilotDetails' => (!\is_null($localArray)) ? $localArray['pilotDetails'] : null,
                'characterList' => (!\is_null($localArray)) ? $localArray['pilotList'] : null,
                'corporationList' => (!\is_null($participationData)) ? $participationData['corporationList'] : null,
                'allianceList' => (!\is_null($participationData)) ? $participationData['allianceList'] : null,
                'corporationParticipation' => (!\is_null($participationData)) ? $participationData['corporationParticipation'] : null,
                'allianceParticipation' => (!\is_null($participationData)) ? $participationData['allianceParticipation'] : null,
                'coalitionParticipation' => $this->getCoalitionParticipation($participationData, $localArray['pilotList'])
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
    public function getLocalArray(string $scanData) {
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
        $corporationSheet = [];

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

                foreach($characterAffiliationData as $characterAffiliatedIds) {
                    if(\is_a($characterAffiliatedIds, '\WordPress\EsiClient\Model\Character\CharactersAffiliation')) {
                        /* @var $characterAffiliatedIds \WordPress\EsiClient\Model\Character\CharactersAffiliation */
                        $pilotDetails[$characterAffiliatedIds->getCharacterId()] = [
                            'characterID' => $characterAffiliatedIds->getCharacterId(),
                            'characterName' => $pilotList[$characterAffiliatedIds->getCharacterId()]
                        ];

                        /**
                         * Grabbing corporation information
                         */
                        if(!\is_null($characterAffiliatedIds->getCorporationId())) {
                            if(!isset($corporationSheet[$characterAffiliatedIds->getCorporationId()])) {
                                $corporationSheet[$characterAffiliatedIds->getCorporationId()] = $this->esiHelper->getCorporationData($characterAffiliatedIds->getCorporationId());
                            }

                            if(!\is_null($corporationSheet[$characterAffiliatedIds->getCorporationId()])) {
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationID'] = $characterAffiliatedIds->getCorporationId();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationName'] = $corporationSheet[$characterAffiliatedIds->getCorporationId()]->getName();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['corporationTicker'] = $corporationSheet[$characterAffiliatedIds->getCorporationId()]->getTicker();
                            }
                        }

                        /**
                         * Grabbing alliance information
                         */
                        if(!\is_null($characterAffiliatedIds->getAllianceId())) {
                            /* @var $allianceSheet \WordPress\EsiClient\Model\Alliance\AlliancesAllianceId */
                            $allianceSheet = $this->esiHelper->getAllianceData($characterAffiliatedIds->getAllianceId());

                            if(!\is_null($allianceSheet)) {
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceID'] = $characterAffiliatedIds->getAllianceId();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceName'] = $allianceSheet->getName();
                                $pilotDetails[$characterAffiliatedIds->getCharacterId()]['allianceTicker'] = $allianceSheet->getTicker();
                            }
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

                $counter[\sanitize_title($pilotSheet['corporationName'])]++;

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

                $counter[\sanitize_title($pilotSheet['allianceName'])]++;

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

                $counter[\sanitize_title('Unaffiliated / No Alliance')]++;

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

    public function getCoalitionParticipation(array $participationData, $pilotList) {
        $returnValue = null;

        if(!\is_null($participationData['allianceParticipation'])) {
            $coalitionData = $this->coalitionHelper->getCoalitionInformation();
            $coalitionParticipation = [];
            $coalitionAffiliation = [];
            $count = [];
            $count['total'] = 0;

            foreach($coalitionData as $coalitionInfo) {
                $count[$coalitionInfo->_id] = 0;

                foreach($coalitionInfo->alliances as $coalitionAlliance) {
                    foreach($participationData['allianceParticipation'] as $participationNumber) {
                        foreach($participationNumber as $participatedAlliance) {
                            if($participatedAlliance['allianceID'] === $coalitionAlliance->id) {
                                $count[$coalitionInfo->_id] += $participatedAlliance['count'];
                                $count['total'] += $participatedAlliance['count'];
                                $coalitionAffiliation[$coalitionInfo->_id] = $coalitionInfo;
                            }
                        }
                    }
                }
            }

            foreach($coalitionAffiliation as $affiliation) {
                $coalitionParticipation['coalition'][$count[$affiliation->_id]][$affiliation->_id]['count'] = $count[$affiliation->_id];
                $coalitionParticipation['coalition'][$count[$affiliation->_id]][$affiliation->_id]['percentage'] = 100 / \count($pilotList) * $count[$affiliation->_id];
                $coalitionParticipation['coalition'][$count[$affiliation->_id]][$affiliation->_id]['data'] = $affiliation;
            }

            $countUnaffiliated = \count($pilotList) - $count['total'];

            $coalitionParticipation['unaffiliated']['count'] = $countUnaffiliated;
            $coalitionParticipation['unaffiliated']['percentage'] = 100 / \count($pilotList) * $countUnaffiliated;

            \krsort($coalitionParticipation['coalition']);

            $returnValue = $coalitionParticipation;
        }

        return $returnValue;
    }
}
