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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\StringHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\DscanParser;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\FleetCompositionParser;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Parser\LocalScanParser;

/**
 * Parsing our intel data
 */
class IntelParser {
    /**
     * Intel data to parse
     *
     * @var mixed
     */
    public mixed $eveIntel;

    /**
     * Unique ID for this run
     *
     * @var string
     */
    public string $uniqueID;

    /**
     * ID of the new post
     *
     * @var int|null
     */
    public ?int $postID;

    /**
     * Constructor
     */
    public function __construct() {
        $nonce = filter_input(type: INPUT_POST, var_name: '_wpnonce');

        if (!wp_verify_nonce(nonce: $nonce, action: 'eve-online-intel-tool-new-intel-form')) {
            die('Busted!');
        }

        $this->eveIntel = filter_input(type: INPUT_POST, var_name: 'eveIntel');
        $this->uniqueID = uniqid(prefix: '', more_entropy: true);

        /**
         * Let's get the intel type
         */
        $intelType = $this->checkIntelType(scanData: $this->eveIntel);

        $this->postID = match ($intelType) {
            'dscan' => $this->saveDscanData(scanData: $this->eveIntel),
            'fleetcomposition' => $this->saveFleetComositionData(scanData: $this->eveIntel),
            'local' => $this->saveLocalScanData(scanData: $this->eveIntel),
            default => null,
        };
    }

    /**
     * Determine what type of intel we might have
     *
     * @param string $scanData
     * @return string|null
     */
    private function checkIntelType(string $scanData): ?string {

        /**
         * Correcting line breaks
         *
         * mac -> linux
         * windows -> linux
         */
        $cleanedScanData = StringHelper::getInstance()->fixLineBreaks(scanData: $scanData);

        switch ($cleanedScanData) {
            /**
             * First: Fleet Comp
             */
            case (bool)preg_match(pattern: '/^([a-zA-Z0-9 -_]{3,37})[\t](.*)[\t](.* \/ .*) ?$/m', subject: $cleanedScanData):
                $intelType = 'fleetcomposition';
                break;

            /**
             * Second: D-Scan
             */
            case (bool)preg_match(pattern: '/^\d+[\t](.*)[\t](-|\d(.*)) ?$/m', subject: $cleanedScanData):
                $intelType = 'dscan';
                break;

            /**
             * Third: Chat Scan
             */
            case (bool)preg_match(pattern: '/^[a-zA-Z0-9 -_]{3,37}$/m', subject: $cleanedScanData):
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
     * @return int|null
     */
    private function saveDscanData(string $scanData): ?int {
        $returnData = null;

        $parsedDscanData = DscanParser::getInstance()->parseDscan(scanData: $scanData);

        if ($parsedDscanData !== null) {
            $postName = $this->uniqueID;

            /**
             * If we have a system, add it to the post-title
             */
            if (!empty($parsedDscanData['systemInformation']['system']['name'])) {
                $postName = $parsedDscanData['systemInformation']['system']['name'];

                if (!empty($parsedDscanData['systemInformation']['constellation']['name'])) {
                    $postName .= ' - ' . $parsedDscanData['systemInformation']['constellation']['name'];
                }

                if (!empty($parsedDscanData['systemInformation']['region']['name'])) {
                    $postName .= ' - ' . $parsedDscanData['systemInformation']['region']['name'];
                }

                $postName .= ' ' . $this->uniqueID;
            }

            $metaData = [
                'eve-intel-tool_dscan-rawData' => maybe_serialize(
                    data: StringHelper::getInstance()->fixLineBreaks(scanData: $scanData)
                ),
                'eve-intel-tool_dscan-all' => maybe_serialize(
                    data: $parsedDscanData['all']
                ),
                'eve-intel-tool_dscan-onGrid' => maybe_serialize(
                    data: $parsedDscanData['onGrid']
                ),
                'eve-intel-tool_dscan-offGrid' => maybe_serialize(
                    data: $parsedDscanData['offGrid']
                ),
                'eve-intel-tool_dscan-shipTypes' => maybe_serialize(
                    data: $parsedDscanData['shipTypes']
                ),
                'eve-intel-tool_dscan-system' => maybe_serialize(
                    data: $parsedDscanData['systemInformation']
                ),
                'eve-intel-tool_dscan-upwellStructures' => maybe_serialize(
                    data: $parsedDscanData['upwellStructures']
                ),
                'eve-intel-tool_dscan-deployables' => maybe_serialize(
                    data: $parsedDscanData['deployables']
                ),
                'eve-intel-tool_dscan-miscellaneous' => maybe_serialize(
                    data: $parsedDscanData['miscellaneous']
                ),
                'eve-intel-tool_dscan-starbaseModules' => maybe_serialize(
                    data: $parsedDscanData['starbaseModules']
                ),
                'eve-intel-tool_dscan-lootSalvage' => maybe_serialize(
                    data: $parsedDscanData['lootSalvage']
                ),
                'eve-intel-tool_dscan-time' => maybe_serialize(
                    data: gmdate(format: 'Y-m-d H:i:s', timestamp: time())
                ),
            ];

            $returnData = $this->savePostdata(
                postName: $postName,
                metaData: $metaData,
                category: 'dscan'
            );
        }

        return $returnData;
    }

    /**
     * Save the post-data
     *
     * @param string $postName
     * @param array $metaData
     * @param string $category
     * @return int|null
     */
    private function savePostdata(string $postName, array $metaData, string $category): ?int {
        $postTitle = null;
        $returnData = null;

        switch ($category) {
            case 'dscan':
                $postTitle = 'D-Scan: ' . wp_filter_kses(data: $postName);
                break;

            case 'fleetcomposition':
                $postTitle = 'Fleet Composition: ' . wp_filter_kses(data: $postName);
                break;

            case 'local':
                $postTitle = 'Chat Scan: ' . wp_filter_kses(data: $postName);
                break;
        }

        if ($postTitle !== null) {
            $newPostID = wp_insert_post(
                postarr: [
                    'post_title' => $postTitle,
                    'post_name' => sanitize_title(title: $postTitle),
                    'post_content' => '',
                    'post_category' => '',
                    'post_status' => 'publish',
                    'post_type' => 'intel',
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'meta_input' => $metaData
                ],
                wp_error: true
            );

            if ($newPostID) {
                wp_set_object_terms(
                    object_id: $newPostID,
                    terms: $category,
                    taxonomy: 'intel_category'
                );

                $returnData = $newPostID;
            }
        }

        return $returnData;
    }

    /**
     * Saving the fleet composition data
     *
     * @param string $scanData
     * @return int|null
     */
    private function saveFleetComositionData(string $scanData): ?int {
        $returnData = null;
        $parsedFleetComposition = FleetCompositionParser::getInstance()
            ->parseFleetCompositionScan(scanData: $scanData);

        if ($parsedFleetComposition !== null) {
            $postName = $this->uniqueID;
            $metaData = [
                'eve-intel-tool_fleetcomposition-rawData' => maybe_serialize(
                    data: $parsedFleetComposition['rawData']
                ),
                'eve-intel-tool_fleetcomposition-fleetOverview' => maybe_serialize(
                    data: $parsedFleetComposition['fleetCompositionData']['overview']
                ),
                'eve-intel-tool_fleetcomposition-fleetInformation' => maybe_serialize(
                    data: $parsedFleetComposition['fleetInformation']
                ),
                'eve-intel-tool_fleetcomposition-shipClasses' => maybe_serialize(
                    data: $parsedFleetComposition['fleetCompositionData']['shipClasses']
                ),
                'eve-intel-tool_fleetcomposition-shipTypes' => maybe_serialize(
                    data: $parsedFleetComposition['fleetCompositionData']['shipTypes']
                ),
                'eve-intel-tool_fleetcomposition-pilotDetails' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['pilotDetails']
                ),
                'eve-intel-tool_fleetcomposition-pilotList' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['characterList']
                ),
                'eve-intel-tool_fleetcomposition-corporationList' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['corporationList']
                ),
                'eve-intel-tool_fleetcomposition-allianceList' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['allianceList']
                ),
                'eve-intel-tool_fleetcomposition-corporationParticipation' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['corporationParticipation']
                ),
                'eve-intel-tool_fleetcomposition-allianceParticipation' => maybe_serialize(
                    data: $parsedFleetComposition['participationData']['allianceParticipation']
                ),
                'eve-intel-tool_fleetcomposition-time' => maybe_serialize(
                    data: gmdate(format: 'Y-m-d H:i:s', timestamp: time())
                ),
            ];

            $returnData = $this->savePostdata(
                postName: $postName,
                metaData: $metaData,
                category: 'fleetcomposition'
            );
        }

        return $returnData;
    }

    /**
     * Saving the local/chat scan data
     *
     * @param string $scanData
     * @return int|null
     */
    private function saveLocalScanData(string $scanData): ?int {
        $returnData = null;

        $parsedLocalData = LocalScanParser::getInstance()
            ->parseLocalScan(scanData: $scanData);

        if ($parsedLocalData !== null) {
            $postName = $this->uniqueID;
            $metaData = [
                'eve-intel-tool_local-rawData' => maybe_serialize(
                    data: $parsedLocalData['rawData']
                ),
                'eve-intel-tool_local-pilotDetails' => maybe_serialize(
                    data: $parsedLocalData['pilotDetails']
                ),
                'eve-intel-tool_local-pilotList' => maybe_serialize(
                    data: $parsedLocalData['characterList']
                ),
                'eve-intel-tool_local-corporationList' => maybe_serialize(
                    data: $parsedLocalData['corporationList']
                ),
                'eve-intel-tool_local-allianceList' => maybe_serialize(
                    data: $parsedLocalData['allianceList']
                ),
                'eve-intel-tool_local-corporationParticipation' => maybe_serialize(
                    data: $parsedLocalData['corporationParticipation']
                ),
                'eve-intel-tool_local-allianceParticipation' => maybe_serialize(
                    data: $parsedLocalData['allianceParticipation']
                ),
                'eve-intel-tool_local-time' => maybe_serialize(
                    data: gmdate(format: 'Y-m-d H:i:s', timestamp: time())
                ),
            ];

            $returnData = $this->savePostdata(
                postName: $postName,
                metaData: $metaData,
                category: 'local'
            );
        }

        return $returnData;
    }
}
