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

// Counter
$countAll = (!empty($intelData['dscanDataAll']['count'])) ? $intelData['dscanDataAll']['count'] : 0;
$countOnGrid = (!empty($intelData['dscanDataOnGrid']['count'])) ? $intelData['dscanDataOnGrid']['count'] : 0;
$countOffGrid = (!empty($intelData['dscanDataOffGrid']['count'])) ? $intelData['dscanDataOffGrid']['count'] : 0;

// System data
$systemData = (!empty($intelData['dscanDataSystem'])) ? $intelData['dscanDataSystem'] : null;
?>

<header class="page-title">
    <h1><?php echo \__('D-Scan', 'eve-online-intel-tool'); ?></h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        ?>
        <div><p><small><?php echo \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime']; ?></small></p></div>
        <?php
    }

    TemplateHelper::getInstance()->getTemplate('partials/extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <!--
            // General system information
            -->
            <?php
            if(!\is_null($systemData)) {
                TemplateHelper::getInstance()->getTemplate('partials/dscan/system-information', [
                    'systemData' => $systemData
                ]);
            }
            ?>

            <?php
            /**
             * D-Scan Breakdown
             */
            TemplateHelper::getInstance()->getTemplate('partials/dscan/dscan-breakdown', [
                'countAll' => $countAll,
                'countOnGrid' => $countOnGrid,
                'countOffGrid' => $countOffGrid,
                'intelData' => $intelData
            ]);

            /**
             * Interesting on grid
             */
            if(!empty($intelData['dscanUpwellStructures']) || !empty($intelData['dscanDeployables'])) {
                TemplateHelper::getInstance()->getTemplate('partials/dscan/interesting-on-grid-breakdown', [
                    'countAll' => $countAll,
                    'countOnGrid' => $countOnGrid,
                    'countOffGrid' => $countOffGrid,
                    'intelData' => $intelData
                ]);
            }
            ?>
        </div>
    </section>
</article><!-- /.post-->
