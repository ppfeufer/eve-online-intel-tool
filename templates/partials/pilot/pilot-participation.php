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
<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $pilotCount; ?>)</h2></header>
<?php
if(!empty($pilotParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-pilots table-eve-intel">
        <table class="table table-sortable table-condensed eve-intel-pilot-participation-list" data-haspaging="no">
            <thead>
                <th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Alliance', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Corporation', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($pilotParticipation as $pilot) {
                if(!isset($pilot['allianceID'])) {
                    $pilot['allianceID'] = 0;
                }
                ?>
                <tr class="eve-intel-pilot-participation-item eve-intel-alliance-id-<?php echo $pilot['allianceID']; ?> eve-intel-corporation-id-<?php echo $pilot['corporationID']; ?> eve-intel-pilot-id-<?php echo $pilot['characterID']; ?>" data-alliance-id="<?php echo $pilot['allianceID']; ?>" data-corporation-id="<?php echo $pilot['corporationID']; ?>" data-character-id="<?php echo $pilot['characterID']; ?>">
                    <td>
                        <?php
                        TemplateHelper::getInstance()->getTemplate('partials/pilot/pilot-avatar', [
                            'data' => $pilot
                        ]);

                        TemplateHelper::getInstance()->getTemplate('partials/pilot/pilot-information', [
                            'data' => [
                                'characterID' => $pilot['characterID'],
                                'characterName' => $pilot['characterName']
                            ]
                        ]);
                        ?>
                    </td>

                    <td data-search="<?php echo $pilot['allianceName']; ?>, <?php echo $pilot['allianceTicker']; ?>">
                        <?php
                        if(!\is_null($pilot['allianceID']) && $pilot['allianceID'] !== 0) {
                            TemplateHelper::getInstance()->getTemplate('partials/alliance/alliance-logo', [
                                'data' => $pilot
                            ]);

                            echo $pilot['allianceTicker'];
                        }
                        ?>
                    </td>

                    <td data-search="<?php echo $pilot['corporationName']; ?>, <?php echo $pilot['corporationTicker']; ?>>
                        <?php
                        TemplateHelper::getInstance()->getTemplate('partials/corporation/corporation-logo', [
                            'data' => $pilot
                        ]);

                        echo $pilot['corporationTicker'];
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
