<?php

/*
 * Copyright (C) 2018 p.pfeufer
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

/* @var $templateHelper TemplateHelper */
$templateHelper = TemplateHelper::getInstance();
?>
<div class="system-information row">
    <div class="col-md-12">
        <div class="row">
            <?php
            $templateHelper->getTemplate('partials/dscan/system-data/system-information', [
                'systemData' => $systemData
            ]);

            $templateHelper->getTemplate('partials/dscan/system-data/system-activity', [
                'systemData' => $systemData
            ]);

            $templateHelper->getTemplate('partials/dscan/system-data/system-status', [
                'systemData' => $systemData
            ]);
            ?>
        </div>
    </div>
</div>
