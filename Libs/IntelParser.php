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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs;

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\DscanParser;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\FleetCompositionParser;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\LocalScanParser;

\defined('ABSPATH') or die();

/**
 * Parsing our intel data
 */
class IntelParser {
    /**
     * Intel data to parse
     *
     * @var string
     */
    public $eveIntel = null;

    /**
     * Unique ID for this run
     *
     * @var string
     */
    public $uniqueID = null;

    /**
     * ID of the new post
     *
     * @var int
     */
    public $postID = null;

    /**
     * Constructor
     */
    public function __construct() {
        $nonce = \filter_input(\INPUT_POST, '_wpnonce');

        if(!\wp_verify_nonce($nonce, 'eve-online-intel-tool-new-intel-form')) {
            die('Busted!');
        }

        $this->eveIntel = \filter_input(\INPUT_POST, 'eveIntel');
        $this->uniqueID = \uniqid();

        /**
         * Let's get the intel type
         */
        $intelType = $this->checkIntelType($this->eveIntel);

        switch($intelType) {
            /**
             * Error / non parsable data
             */
            case null:
                $this->postID = null;
                break;

            /**
             * D-Scan
             */
            case 'dscan':
                $this->postID = $this->saveDscanData($this->eveIntel);
                break;

            /**
             * Fleet Composition
             */
            case 'fleetcomposition':
                $this->postID = $this->saveFleetComositionData($this->eveIntel);
                break;

            /**
             * Chat Scan
             */
            case 'local':
                $this->postID = $this->saveLocalScanData($this->eveIntel);
                break;

            /**
             * Default
             */
            default:
                $this->postID = null;
                break;
        }
    }

    /**
     * Determine what type of intel we might have
     *
     * @param string $scanData
     * @return string
     */
    private function checkIntelType(string $scanData) {
        $intelType = null;

        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = StringHelper::getInstance()->fixLineBreaks($scanData);

        switch($cleanedScanData) {
            case '':
                $intelType = null;
                break;

            /**
             * First: Fleet Comp
             */
            case (\preg_match('/^([a-zA-Z0-9 -_]{3,37})[\t](.*)[\t](.* \/ .*) ?$/m', $cleanedScanData) ? true : false):
                $intelType = 'fleetcomposition';
                break;

            /**
             * Second: D-Scan
             */
            case (\preg_match('/^\d+[\t](.*)[\t](-|\d(.*)) ?$/m', $cleanedScanData) ? true : false):
                $intelType = 'dscan';
                break;

            /**
             * Third: Chat Scan
             */
            case (\preg_match('/^[a-zA-Z0-9 -_]{3,37}$/m', $cleanedScanData) ? true : false):
                $intelType = 'local';
                break;

            default:
                $intelType = null;
                break;
        }

        return $intelType;
    }

    /**
     * Saving the D-Scan data
     *
     * @param string $scanData
     * @return int
     */
    private function saveDscanData(string $scanData) {
        $returnData = null;

        $parsedDscanData = DscanParser::getInstance()->parseDscan($scanData);

        if($parsedDscanData !== null) {
            $postName = $this->uniqueID;

            /**
             * If we have a system, add it to the post title
             */
            if(!empty($parsedDscanData['systemInformation']['system']['name'])) {
                $postName = $parsedDscanData['systemInformation']['system']['name'];

                if(!empty($parsedDscanData['systemInformation']['constellation']['name'])) {
                    $postName .= ' - ' . $parsedDscanData['systemInformation']['constellation']['name'];
                }

                if(!empty($parsedDscanData['systemInformation']['region']['name'])) {
                    $postName .= ' - ' . $parsedDscanData['systemInformation']['region']['name'];
                }

                $postName .= ' ' . $this->uniqueID;
            }

            $metaData = [
                'eve-intel-tool_dscan-rawData' => \maybe_serialize(StringHelper::getInstance()->fixLineBreaks($scanData)),
                'eve-intel-tool_dscan-all' => \maybe_serialize($parsedDscanData['all']),
                'eve-intel-tool_dscan-onGrid' => \maybe_serialize($parsedDscanData['onGrid']),
                'eve-intel-tool_dscan-offGrid' => \maybe_serialize($parsedDscanData['offGrid']),
                'eve-intel-tool_dscan-shipTypes' => \maybe_serialize($parsedDscanData['shipTypes']),
                'eve-intel-tool_dscan-system' => \maybe_serialize($parsedDscanData['systemInformation']),
                'eve-intel-tool_dscan-upwellStructures' => \maybe_serialize($parsedDscanData['upwellStructures']),
                'eve-intel-tool_dscan-deployables' => \maybe_serialize($parsedDscanData['deployables']),
                'eve-intel-tool_dscan-miscellaneous' => \maybe_serialize($parsedDscanData['miscellaneous']),
                'eve-intel-tool_dscan-starbaseModules' => \maybe_serialize($parsedDscanData['starbaseModules']),
                'eve-intel-tool_dscan-lootSalvage' => \maybe_serialize($parsedDscanData['lootSalvage']),
                'eve-intel-tool_dscan-time' => \maybe_serialize(\gmdate('Y-m-d H:i:s', \time())),
            ];

            $returnData = $this->savePostdata($postName, $metaData, 'dscan');
        }

        return $returnData;
    }

    /**
     * Saving the fleet composition data
     *
     * @param string $scanData
     * @return int
     */
    private function saveFleetComositionData(string $scanData) {
        $returnData = null;
        $parsedFleetComposition = FleetCompositionParser::getInstance()->parseFleetCompositionScan($scanData);

        if($parsedFleetComposition !== null) {
            $postName = $this->uniqueID;
            $metaData = [
                'eve-intel-tool_fleetcomposition-rawData' => \maybe_serialize($parsedFleetComposition['rawData']),
                'eve-intel-tool_fleetcomposition-fleetOverview' => \maybe_serialize($parsedFleetComposition['fleetCompositionData']['overview']),
                'eve-intel-tool_fleetcomposition-fleetInformation' => \maybe_serialize($parsedFleetComposition['fleetInformation']),
                'eve-intel-tool_fleetcomposition-shipClasses' => \maybe_serialize($parsedFleetComposition['fleetCompositionData']['shipClasses']),
                'eve-intel-tool_fleetcomposition-shipTypes' => \maybe_serialize($parsedFleetComposition['fleetCompositionData']['shipTypes']),
                'eve-intel-tool_fleetcomposition-pilotDetails' => \maybe_serialize($parsedFleetComposition['participationData']['pilotDetails']),
                'eve-intel-tool_fleetcomposition-pilotList' => \maybe_serialize($parsedFleetComposition['participationData']['characterList']),
                'eve-intel-tool_fleetcomposition-corporationList' => \maybe_serialize($parsedFleetComposition['participationData']['corporationList']),
                'eve-intel-tool_fleetcomposition-allianceList' => \maybe_serialize($parsedFleetComposition['participationData']['allianceList']),
                'eve-intel-tool_fleetcomposition-corporationParticipation' => \maybe_serialize($parsedFleetComposition['participationData']['corporationParticipation']),
                'eve-intel-tool_fleetcomposition-allianceParticipation' => \maybe_serialize($parsedFleetComposition['participationData']['allianceParticipation']),
                'eve-intel-tool_fleetcomposition-time' => \maybe_serialize(\gmdate('Y-m-d H:i:s', \time())),
            ];

            $returnData = $this->savePostdata($postName, $metaData, 'fleetcomposition');
        }

        return $returnData;
    }

    /**
     * Saving the local/chat scan data
     *
     * @param string $scanData
     * @return int
     */
    private function saveLocalScanData(string $scanData) {
        $returnData = null;

        $parsedLocalData = LocalScanParser::getInstance()->parseLocalScan($scanData);

        if($parsedLocalData !== null) {
            $postName = $this->uniqueID;
            $metaData = [
                'eve-intel-tool_local-rawData' => \maybe_serialize($parsedLocalData['rawData']),
                'eve-intel-tool_local-pilotDetails' => \maybe_serialize($parsedLocalData['pilotDetails']),
                'eve-intel-tool_local-pilotList' => \maybe_serialize($parsedLocalData['characterList']),
                'eve-intel-tool_local-corporationList' => \maybe_serialize($parsedLocalData['corporationList']),
                'eve-intel-tool_local-allianceList' => \maybe_serialize($parsedLocalData['allianceList']),
                'eve-intel-tool_local-corporationParticipation' => \maybe_serialize($parsedLocalData['corporationParticipation']),
                'eve-intel-tool_local-allianceParticipation' => \maybe_serialize($parsedLocalData['allianceParticipation']),
                'eve-intel-tool_local-coalitionParticipation' => \maybe_serialize($parsedLocalData['coalitionParticipation']),
                'eve-intel-tool_local-time' => \maybe_serialize(\gmdate('Y-m-d H:i:s', \time())),
            ];

            $returnData = $this->savePostdata($postName, $metaData, 'local');
        }

        return $returnData;
    }

    /**
     * Save the post data
     *
     * @param string $postName
     * @param array $metaData
     * @param string $category
     * @return int
     */
    private function savePostdata(string $postName, array $metaData, string $category) {
        $returnData = null;

        switch($category) {
            case 'dscan':
                $postTitle = 'D-Scan: ' . \wp_filter_kses($postName);
                break;

            case 'fleetcomposition':
                $postTitle = 'Fleet Composition: ' . \wp_filter_kses($postName);
                break;

            case 'local':
                $postTitle = 'Chat Scan: ' . \wp_filter_kses($postName);
                break;
        }

        $newPostID = \wp_insert_post([
            'post_title' => $postTitle,
            'post_name' => \sanitize_title($postTitle),
            'post_content' => '',
            'post_category' => '',
            'post_status' => 'publish',
            'post_type' => 'intel',
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'meta_input' => $metaData
        ], true);

        if($newPostID) {
            \wp_set_object_terms($newPostID, $category, 'intel_category');

            $returnData = $newPostID;
        }

        return $returnData;
    }
}
