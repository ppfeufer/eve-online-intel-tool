<?php

use \WordPress\EsiClient\Model\Meta\Status;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper;

/*
 * Copyright (C) 2018 Rounon Dax
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

$esiStatus = EsiHelper::getInstance()->getEsiStatusLatest();

if(!is_null($esiStatus)) {
    $greenEndpoints = [];
    $yellowEndpoints = [];
    $redEndpoints = [];
    $countTotalEndpoints = count($esiStatus);
    $countGreenEndpoints = 0;
    $countYellowEndpoints = 0;
    $countRedEndpoints = 0;

    foreach($esiStatus as $endpointStatus) {
        /* @var $endpointStatus Status */
        switch($endpointStatus->getStatus()) {
            case 'green':
                $countGreenEndpoints++;
                $greenEndpoints[$endpointStatus->getTags()['0']][] = $endpointStatus;
                break;

            case 'yellow':
                $countYellowEndpoints++;
                $yellowEndpoints[$endpointStatus->getTags()['0']][] = $endpointStatus;
                break;

            case 'red':
                $countRedEndpoints++;
                $redEndpoints[$endpointStatus->getTags()['0']][] = $endpointStatus;
                break;
        }
    }

    ksort($greenEndpoints);
}
?>

<header>
    <h1><?php echo \__('Current ESI Endpoint Status', 'eve-online-intel-tool'); ?></h1>
</header>
<article class="post clearfix">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo \__('Red Endpoints', 'eve-online-intel-tool'); ?>
                    </h3>
                </div>

                <div class="panel-body text-center">
                    <b style="font-size:140%;"><?php echo $countRedEndpoints; ?></b><br>
                    <span>
                        (<?php echo number_format(100 / $countTotalEndpoints * $countRedEndpoints, 2) . '%'; ?>)
                    </span>
                </div>

                <div class="panel-footer">
                    <?php
                    if($countRedEndpoints > 0) {
                        foreach($redEndpoints as $categoryKey => $categoryEndpoints) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" href="#<?php echo sanitize_title($categoryKey); ?>-red" aria-expanded="false" aria-controls="<?php echo sanitize_title($categoryKey); ?>-red">
                                    <h4 class="panel-title">
                                        <?php echo $categoryKey; ?>
                                    </h4>
                                </div>

                                <div id="<?php echo \sanitize_title($categoryKey); ?>-red" class="panel-body collapse">
                                    <?php
                                    foreach($categoryEndpoints as $redEndpoint) {
                                        /* @var $yellowEndpoint Status */
                                        ?>
                                        <p class="small">
                                            <?php echo strtoupper($redEndpoint->getMethod()); ?>
                                            <?php echo $redEndpoint->getRoute(); ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo \__('Yellow Endpoints', 'eve-online-intel-tool'); ?>
                    </h3>
                </div>

                <div class="panel-body text-center">
                    <b style="font-size:140%;"><?php echo $countYellowEndpoints; ?></b><br>
                    <span>
                        (<?php echo number_format(100 / $countTotalEndpoints * $countYellowEndpoints, 2) . '%'; ?>)
                    </span>
                </div>

                <div class="panel-footer">
                    <?php
                    if($countYellowEndpoints > 0) {
                        foreach($yellowEndpoints as $categoryKey => $categoryEndpoints) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" href="#<?php echo \sanitize_title($categoryKey); ?>-yellow" aria-expanded="false" aria-controls="<?php echo \sanitize_title($categoryKey); ?>-yellow">
                                    <h4 class="panel-title">
                                        <?php echo $categoryKey; ?>
                                    </h4>
                                </div>

                                <div id="<?php echo \sanitize_title($categoryKey); ?>-yellow" class="panel-body collapse">
                                    <?php
                                    foreach($categoryEndpoints as $yellowEndpoint) {
                                        /* @var $yellowEndpoint Status */
                                        ?>
                                        <p class="small">
                                            <?php echo strtoupper($yellowEndpoint->getMethod()); ?>
                                            <?php echo $yellowEndpoint->getRoute(); ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo \__('Green Endpoints', 'eve-online-intel-tool'); ?>
                    </h3>
                </div>

                <div class="panel-body text-center">
                    <b style="font-size:140%;"><?php echo $countGreenEndpoints; ?></b><br>
                    <span>
                        (<?php echo number_format(100 / $countTotalEndpoints * $countGreenEndpoints, 2) . '%'; ?>)
                    </span>
                </div>

                <div class="panel-footer">
                    <?php
                    if($countGreenEndpoints > 0) {
                        foreach($greenEndpoints as $categoryKey => $categoryEndpoints) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" href="#<?php echo \sanitize_title($categoryKey); ?>-green" aria-expanded="false" aria-controls="<?php echo \sanitize_title($categoryKey); ?>-green">
                                    <h4 class="panel-title">
                                        <?php echo $categoryKey; ?>
                                    </h4>
                                </div>

                                <div id="<?php echo \sanitize_title($categoryKey); ?>-green" class="panel-body collapse">
                                    <?php
                                    foreach($categoryEndpoints as $greenEndpoint) {
                                        /* @var $greenEndpoint Status */
                                        ?>
                                        <p class="small">
                                            <?php echo strtoupper($greenEndpoint->getMethod()); ?>
                                            <?php echo $greenEndpoint->getRoute(); ?>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>
