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
?>

<header class="page-title">
    <h1><?php echo \__('Fleet Composition', 'eve-online-intel-tool'); ?></h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        ?>
        <div><p><small><?php echo \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime']; ?></small></p></div>
        <?php
    }

    TemplateHelper::getTemplate('partials/extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <div class="fleetcomposition-information row">
                <!--
                // General fleet information
                -->
                <?php
                if(\is_array($intelData['shipTypes']) && \count($intelData['shipTypes'])) {
                    TemplateHelper::getTemplate('partials/fleet/fleet-information', [
                        'pilotCount' => \count($intelData['pilotList']),
                        'fleetInformation' => $intelData['fleetInformation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                }
                ?>
            </div>

            <div class="fleetcomposition-result row">
                <!--
                // Ship class overview
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    if(\is_array($intelData['shipClasses']) && \count($intelData['shipClasses'])) {
                        TemplateHelper::getTemplate('partials/ship/ship-classes', [
                            'title' => \__('Ship Classes', 'eve-online-intel-tool'),
                            'shipClassList' => $intelData['shipClasses'],
                            'pluginSettings' => $pluginSettings
                        ]);
                    }
                    ?>
                </div>

                <!--
                // Ship type overview
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    if(\is_array($intelData['shipTypes']) && \count($intelData['shipTypes'])) {
                        TemplateHelper::getTemplate('partials/ship/ship-types', [
                            'title' => \__('Ship Types', 'eve-online-intel-tool'),
                            'shipTypeList' => $intelData['shipTypes'],
                            'pluginSettings' => $pluginSettings
                        ]);
                    }
                    ?>
                </div>

                <!--
                // Who is flying what?
                -->
                <div class="col-md-12 col-lg-6">
                    <?php
                    TemplateHelper::getTemplate('partials/fleet/fleet-composition', [
                        'fleetOverview' => $intelData['fleetOverview'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>
            </div>

            <div class="fleetcomposition-result row">
                <div class="clearfix">
                    <div class="col-sm-6 col-md-4 col-lg-3 clearfix">
                        <header class="eve-intel-section-header">
                            <h3><?php echo \__('Participation Details', 'eve-online-intel-tool'); ?></h3>
                        </header>
                    </div>
                </div>

                <!--
                // Alliance participation
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    TemplateHelper::getTemplate('partials/alliance/alliance-participation', [
                        'allianceCount' => \count($intelData['allianceList']),
                        'allianceParticipation' => $intelData['allianceParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <!--
                // Corporation participation
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    TemplateHelper::getTemplate('partials/corporation/corporation-participation', [
                        'corporationCount' => \count($intelData['corporationList']),
                        'corporationParticipation' => $intelData['corporationParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <!--
                // Pilots participation and breakdown to corporations and alliances
                -->
                <div class="col-md-12 col-lg-6">
                    <?php
                    TemplateHelper::getTemplate('partials/pilot/pilot-participation', [
                        'pilotCount' => \count($intelData['pilotList']),
                        'pilotParticipation' => $intelData['pilotParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>
</article><!-- /.post-->
