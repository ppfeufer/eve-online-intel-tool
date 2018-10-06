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

?>
<div class="dscan-result row">
    <div class="clearfix">
        <div class="col-sm-6 col-md-4 col-lg-3 clearfix">
            <header class="eve-intel-section-header">
                <h3><?php echo \__('Interesting On Grid', 'eve-online-intel-tool'); ?></h3>
            </header>
        </div>
    </div>

    <!--
    // Upwell Structures
    -->
    <div class="col-sm-6 col-md-4 col-lg-3">
        <?php
        TemplateHelper::getInstance()->getTemplate('partials/dscan/structures-on-grid', [
            'title' => \__('Upwell Structures', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanUpwellStructures']
        ]);
        ?>
    </div>

    <!--
    // Deployables
    -->
    <div class="col-sm-6 col-md-4 col-lg-3">
        <?php
        TemplateHelper::getInstance()->getTemplate('partials/dscan/structures-on-grid', [
            'title' => \__('Deployables', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanDeployables']
        ]);
        ?>
    </div>

    <!--
    // Starbases / Starbase Modules
    -->
    <div class="col-md-4 col-sm-6 col-lg-3">
        <?php
        TemplateHelper::getInstance()->getTemplate('partials/dscan/structures-on-grid', [
            'title' => \__('POS / POS Modules', 'eve-online-intel-tool'),
            'structures' => $intelData['dscanStarbaseModules']
        ]);
        ?>
    </div>
</div>
