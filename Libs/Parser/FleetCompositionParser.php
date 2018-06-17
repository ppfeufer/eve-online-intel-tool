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

class FleetCompositionParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * EVE Swagger Interface
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper
     */
    private $esi = null;

    /**
     * Intel Helper
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper
     */
    private $intelHelper = null;

    /**
     * Local Parser
     *
     * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Parser\LocalScanParser
     */
    private $localParser = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->esi = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
        $this->intelHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper::getInstance();
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
        $cleanedScanData = $this->intelHelper->fixLineBreaks($scanData);

        $pilotListRaw = null;
        $fleetInformation = [];
        $counter = [];

        foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
            /**
             * Break the text down into an array
             *
             * Array
             * 	(
             * 		[0] => Pilot Name
             * 		[1] => System (Docked)
             * 		[2] => Ship Class
             * 		[3] => Ship Type
             * 		[4] => Position in Fleet
             * 		[5] => Skills (FC - WC - SC)
             * 		[6] => Wing Name / Squad Name
             * 	)
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
            $pilotOverview[\sanitize_title($lineDetailsArray['0'])] = [
                'pilotName' => $lineDetailsArray['0'],
                'pilotID' => $this->esi->getEveIdFromName($lineDetailsArray['0'], 'character'),
                'system' => $lineDetailsArray['1'],
                'shipClass' => $lineDetailsArray['2'],
                'shipType' => $lineDetailsArray['3'],
//                'positionInFleet' => $lineDetailsArray['4'],
//                'skills' => $lineDetailsArray['5'],
//                'fleetHirarchy' => $lineDetailsArray['6']
            ];

            // Ship Classes
            if(!isset($counter['class'][\sanitize_title($lineDetailsArray['2'])])) {
                $counter['class'][\sanitize_title($lineDetailsArray['2'])] = 0;
            }

            $counter['class'][\sanitize_title($lineDetailsArray['2'])] ++;
            $shipClassBreakdown[\sanitize_title($lineDetailsArray['2'])] = [
                'shipName' => $lineDetailsArray['2'],
                'shipID' => $this->esi->getEveIdFromName($lineDetailsArray['2'], 'inventory_type'),
                'shipTypeSanitized' => \sanitize_title($lineDetailsArray['3']),
                'count' => $counter['class'][\sanitize_title($lineDetailsArray['2'])]
            ];

            // Ship Types
            if(!isset($counter['type'][\sanitize_title($lineDetailsArray['3'])])) {
                $counter['type'][\sanitize_title($lineDetailsArray['3'])] = 0;
            }

            $counter['type'][\sanitize_title($lineDetailsArray['3'])] ++;
            $shipTypeBreakdown[\sanitize_title($lineDetailsArray['3'])] = [
                'type' => $lineDetailsArray['3'],
                'shipTypeSanitized' => \sanitize_title($lineDetailsArray['3']),
                'count' => $counter['type'][\sanitize_title($lineDetailsArray['3'])]
            ];
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
