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

class FleetCompositionParser extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper
     */
    private $esi = null;

    /**
     * String Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper
     */
    private $stringHelper = null;

    /**
     * Local Parser
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\LocalScanParser
     */
    private $localParser = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esi = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
        $this->stringHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper::getInstance();
        $this->localParser = LocalScanParser::getInstance();
    }

    public function parseFleetCompositionScan($scanData) {
        $returnData = null;
        $fleetCompArray = $this->getFleetCompositionArray($scanData);
  
        if(!\is_null($fleetCompArray)) {
            $returnData = $fleetCompArray;
        }

        return $returnData;
    }

    public function getFleetCompositionArray($scanData) {
        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = $this->stringHelper->fixLineBreaks($scanData);

        $pilotListRaw = null;
        $fleetInformation = [];
        $counter = [];

        foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
            /**
             * Break the text down into an array
             *
             * Array
             *  (
             *      [0] => Pilot Name
             *      [1] => System (Docked)
             *      [2] => Ship Class
             *      [3] => Ship Type
             *      [4] => Position in Fleet
             *      [5] => Skills (FC - WC - SC)
             *      [6] => Wing Name / Squad Name
             *  )
             */
            $lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

            // get the fleet boss
            if(\preg_match('/.* \(Boss\)/', $lineDetailsArray['4'])) {
                $fleetInformation['fleetBoss'] = $lineDetailsArray['0'];
            }

            // get count of docked pilots
            if(!isset($fleetInformation['pilots']['docked'])) {
                $fleetInformation['pilots']['docked'] = 0;
            }

            if(\preg_match('/.* \(Docked\)/', $lineDetailsArray['1'])) {
                $fleetInformation['pilots']['docked'] ++;
            }

            // get count of pilots in space
            if(!isset($fleetInformation['pilots']['inSpace'])) {
                $fleetInformation['pilots']['inSpace'] = 0;
            }

            if(!\preg_match('/.* \(Docked\)/', $lineDetailsArray['1'])) {
                $fleetInformation['pilots']['inSpace'] ++;
            }

            // build a list of pilot names
            $pilotListRaw .= $lineDetailsArray['0'] . "\n";

            // Pilot Details
            $pilotOverview[$lineDetailsArray['0']] = [
                'pilotName' => $lineDetailsArray['0'],
                'system' => $lineDetailsArray['1'],
                'shipClass' => $lineDetailsArray['2'],
                'shipType' => $lineDetailsArray['3'],

                'positionInFleet' => $lineDetailsArray['4'],
                'skills' => $lineDetailsArray['5'],
                'fleetHirarchy' => (isset($lineDetailsArray['6'])) ? $lineDetailsArray['6'] : \__('Fleet Command', 'eve-online-intel-tool')
            ];

            $pilotNames[$lineDetailsArray['0']] = $lineDetailsArray['0'];
            $shipClasses[$lineDetailsArray['2']] = $lineDetailsArray['2'];
        }

        // Get pilot IDs
        $pilotEsiData = $this->esi->getIdFromName($pilotNames, 'characters');
        foreach($pilotEsiData as $pilotIdData) {
            $pilotOverview[$pilotIdData->getName()]['pilotID'] = $pilotIdData->getId();
        }

        // Get ship class IDs
        $shipEsiData = $this->esi->getIdFromName($shipClasses, 'inventoryTypes');

        foreach($pilotOverview as &$pilot) {
            foreach($shipEsiData as $shipData) {
                if($shipData->getName() === $pilot['shipClass']) {
                    // Ship Classes
                    if(!isset($counter['class'][\sanitize_title($shipData->getName())])) {
                        $counter['class'][\sanitize_title($shipData->getName())] = 0;
                    }

                    $counter['class'][\sanitize_title($shipData->getName())] ++;
                    $shipClassBreakdown[\sanitize_title($shipData->getName())] = [
                        'shipName' => $shipData->getName(),
                        'shipID' => $shipData->getId(),
                        'shipTypeSanitized' => \sanitize_title($pilot['shipType']),
                        'count' => $counter['class'][\sanitize_title($shipData->getName())]
                    ];

                    // Ship Types
                    if(!isset($counter['type'][\sanitize_title($pilot['shipType'])])) {
                        $counter['type'][\sanitize_title($pilot['shipType'])] = 0;
                    }

                    $counter['type'][\sanitize_title($pilot['shipType'])] ++;
                    $shipTypeBreakdown[\sanitize_title($pilot['shipType'])] = [
                        'type' => $pilot['shipType'],
                        'shipTypeSanitized' => \sanitize_title($pilot['shipType']),
                        'count' => $counter['type'][\sanitize_title($pilot['shipType'])]
                    ];
                }
            }
        }

        $fleetComposition = [
            'overview' => $pilotOverview,
            'shipClasses' => $shipClassBreakdown,
            'shipTypes' => $shipTypeBreakdown
        ];

        $participationData = $this->localParser->parseLocalScan($pilotListRaw);

        $returnData = [
            'rawData' => $cleanedScanData,
            'fleetInformation' => $fleetInformation,
            'fleetCompositionData' => $fleetComposition,
            'participationData' => $participationData
        ];

        return $returnData;
    }
}
