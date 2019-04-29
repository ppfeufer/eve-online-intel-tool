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
?>

<header class="page-title">
    <h1><?php echo \__('Chat Scan', 'eve-online-intel-tool'); ?></h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        ?>
        <div><p><small><?php echo \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime']; ?></small></p></div>
        <?php
    }

    $templateHelper->getTemplate('partials/extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-local'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <div class="local-scan-result row">
                <div class="col-sm-12">
                    <?php
                    $templateHelper->getTemplate('partials/coalition/coalition-participation', [
                        'coalitionParticipation' => $intelData['localDataCoalitionParticipation']
                    ]);
                    ?>
                </div>
            </div>
            <div class="local-scan-result row">
                <div class="col-md-6 col-lg-3">
                    <?php
                    $templateHelper->getTemplate('partials/alliance/alliance-participation', [
                        'allianceCount' => \count($intelData['localDataAllianceList']),
                        'allianceParticipation' => $intelData['localDataAllianceParticipation']
                    ]);
                    ?>
                </div>

                <div class="col-md-6 col-lg-3">
                    <?php
                    $templateHelper->getTemplate('partials/corporation/corporation-participation', [
                        'corporationCount' => \count($intelData['localDataCorporationList']),
                        'corporationParticipation' => $intelData['localDataCorporationParticipation']
                    ]);
                    ?>
                </div>

                <div class="col-md-12 col-lg-6">
                    <?php
                    $templateHelper->getTemplate('partials/pilot/pilot-participation', [
                        'pilotCount' => \count($intelData['localDataPilotList']),
                        'pilotParticipation' => $intelData['localDataPilotDetails']
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>
</article><!-- /.post-->
