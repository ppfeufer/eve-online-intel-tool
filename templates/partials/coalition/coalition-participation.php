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

/* @var $templateHelper TemplateHelper */
$templateHelper = TemplateHelper::getInstance();
?>
<header class="entry-header"><h2 class="entry-title"><?php echo \__('Coalitions Breakdown', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(!empty($coalitionParticipation)) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="progress">
                <?php
                if(isset($coalitionParticipation['coalition'])) {
                    foreach($coalitionParticipation['coalition'] as $coalitionNumbers) {
                        foreach($coalitionNumbers as $coalition) {
                            ?>
                                <div class="progress-bar" role="progressbar" style="width: <?php echo $coalition['percentage']; ?>%; background-color: <?php echo $coalition['data']->color; ?>;"></div>
                            <?php
                        }
                    }
                }

                if($coalitionParticipation['unaffiliated']['count'] > 0) {
                    ?>
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $coalitionParticipation['unaffiliated']['percentage']; ?>%; background-color: #c0c0c0;"></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        if(isset($coalitionParticipation['coalition'])) {
            foreach($coalitionParticipation['coalition'] as $coalitionNumbers) {
                foreach($coalitionNumbers as $coalition) {
                    ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <?php echo $coalition['data']->name; ?> (<?php echo $coalition['count']; ?>)
                            </div>
                            <div class="col-sm-8">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $coalition['percentage']; ?>%; background-color: <?php echo $coalition['data']->color; ?>;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }

        if($coalitionParticipation['unaffiliated']['count'] > 0) {
            ?>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo __('Unaffiliated', 'eve-online-intel-tool'); ?> (<?php echo $coalitionParticipation['unaffiliated']['count']; ?>)
                    </div>
                    <div class="col-sm-8">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $coalitionParticipation['unaffiliated']['percentage']; ?>%; background-color: #c0c0c0;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
