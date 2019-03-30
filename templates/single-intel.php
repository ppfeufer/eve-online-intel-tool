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

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper;

\defined('ABSPATH') or die();

/* @var $templateHelper TemplateHelper */
$templateHelper = TemplateHelper::getInstance();

// get the intel type
$termObject = \get_the_terms(\get_the_ID(), 'intel_category');
$intelType = 'unknown';
$intelData = [];
$jsonData = [];

switch($termObject['0']->slug) {
    /**
     * D-Scan
     */
    case 'dscan':
        $intelType = 'dscan';

        // Meta data
        $dscanDataAll = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-all', true));
        $dscanDataOnGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-onGrid', true));
        $dscanDataOffGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-offGrid', true));
        $dscanDataShipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-shipTypes', true));
        $dscanUpwellStructures = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-upwellStructures', true));
        $dscanDeployables = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-deployables', true));
        $dscanMiscellaneous = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-miscellaneous', true));
        $dscanStarbaseModules = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-starbaseModules', true));
        $dscanLootSalvage = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-lootSalvage', true));
        $dscanDataSystem = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-system', true));
        $dscanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-time', true));

        $intelData = [
            'dscanDataAll' => $dscanDataAll,
            'dscanDataOnGrid' => $dscanDataOnGrid,
            'dscanDataOffGrid' => $dscanDataOffGrid,
            'dscanDataShipTypes' => $dscanDataShipTypes,
            'dscanDataSystem' => $dscanDataSystem,
            'dscanUpwellStructures' => $dscanUpwellStructures,
            'dscanStarbaseModules' => $dscanStarbaseModules,
            'dscanMiscellaneous' => $dscanMiscellaneous,
            'dscanLootsalvage' => $dscanLootSalvage,
            'dscanDeployables' => $dscanDeployables,
            'eveTime' => $dscanDataTime,
        ];

        $jsonData = [
            'type' => $intelType,
            'eveTime' => $dscanDataTime,
            'data' => [
                'dscanAll' => $dscanDataAll,
                'dscanOngrid' => $dscanDataOnGrid,
                'dscanOffgrid' => $dscanDataOffGrid,
                'dscanShipTypes' => $dscanDataShipTypes,
                'dscanSystemInformation' => $dscanDataSystem
            ]
        ];
        break;

    /**
     * Chat Scan
     */
    case 'local':
        $intelType = 'local';

        // Meta data
        $localDataPilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotList', true));
        $localDataPilotDetails = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotDetails', true));

        $localDataCorporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationList', true));
        $localDataCorporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationParticipation', true));

        $localDataAllianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceList', true));
        $localDataAllianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceParticipation', true));

        $localDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-time', true));

        $intelData = [
            'localDataPilotList' => $localDataPilotList,
            'localDataPilotDetails' => $localDataPilotDetails,
            'localDataCorporationList' => $localDataCorporationList,
            'localDataCorporationParticipation' => $localDataCorporationParticipation,
            'localDataAllianceList' => $localDataAllianceList,
            'localDataAllianceParticipation' => $localDataAllianceParticipation,
            'eveTime' => $localDataTime,
        ];

        $jsonData = [
            'type' => $intelType,
            'eveTime' => $localDataTime,
            'data' => [
                'pilotCount' => \count($localDataPilotList),
                'pilotList' => $localDataPilotList,
                'pilotDetails' => $localDataPilotDetails,

                'corporationList' => $localDataCorporationList,
                'corporationParticipation' => $localDataCorporationParticipation,

                'allianceList' => $localDataAllianceList,
                'allianceParticipation' => $localDataAllianceParticipation
            ]
        ];
        break;

    /**
     * Fleet Comsposition Scan
     */
    case 'fleetcomposition':
        $intelType = 'fleetcomposition';

        // Meta data
        $fleetOverview = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetOverview', true));
        $fleetInformation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetInformation', true));
        $shipClasses = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipClasses', true));
        $shipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipTypes', true));
        $pilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotList', true));
        $pilotParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotDetails', true));
        $corporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationList', true));
        $corporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationParticipation', true));
        $allianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceList', true));
        $allianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceParticipation', true));
        $fleetScanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-time', true));

        $intelData = [
            'fleetOverview' => $fleetOverview,
            'fleetInformation' => $fleetInformation,
            'shipClasses' => $shipClasses,
            'shipTypes' => $shipTypes,
            'pilotList' => $pilotList,
            'pilotParticipation' => $pilotParticipation,
            'corporationList' => $corporationList,
            'corporationParticipation' => $corporationParticipation,
            'allianceList' => $allianceList,
            'allianceParticipation' => $allianceParticipation,
            'eveTime' => $fleetScanDataTime
        ];

        $jsonData = [
            'type' => $intelType,
            'eveTime' => $fleetScanDataTime,
            'data' => [
                'overview' => $fleetOverview,
                'information' => $fleetInformation,
                'shipClasses' => $shipClasses,
                'shipTypes' => $shipTypes,
                'pilotCount' => \count($pilotList),
                'pilotList' => $pilotList,
                'pilotDetails' => $pilotParticipation,
                'corporationList' => $corporationList,
                'corporationParticipation' => $corporationParticipation,
                'allianceList' => $allianceList,
                'allianceParticipation' => $allianceParticipation
            ]
        ];
        break;

    default:
        break;
}

// If the jSon format is requested
$getData = \filter_input(INPUT_GET, 'data');
if(isset($getData) && $getData = 'json') {
    TemplateHelper::getInstance()->getTemplate('json-api/json-data', [
        'jsonData' => \json_encode($jsonData)
    ]);
}

\get_header();
?>

<div class="container container-main">
    <!--<div class="row main-content">-->
    <div class="main-content clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
            <div class="content content-inner content-archive eve-intel-result">
                <?php
                $templateHelper->getTemplate('single-' . $intelType, [
                    'intelData' => $intelData
                ]);
                ?>
            </div> <!-- /.content -->
        </div> <!-- /.col -->
    </div> <!--/.row -->
</div><!-- container -->

<?php
\get_footer();
