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
<header class="entry-header"><h2 class="entry-title"><?php echo \__('Who is flying what', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(\is_array($fleetOverview) && \count($fleetOverview)) {
    ?>
    <div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-fleetinfo table-eve-intel">
        <table class="table table-sortable table-condensed" data-haspaging="no">
            <thead>
                <th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Ship Class', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Where', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($fleetOverview as $data) {
                ?>
                <tr data-highlight="shiptype-<?php echo \sanitize_title($data['shipType']); ?>">
                    <td>
                        <?php
                        TemplateHelper::getTemplate('partials/pilot/pilot-avatar', [
                            'data' => [
                                'characterID' => $data['pilotID'],
                                'characterName' => $data['pilotName']
                            ],
                            'pluginSettings' => $pluginSettings
                        ]);

                        TemplateHelper::getTemplate('partials/pilot/pilot-information', [
                            'data' => [
                                'characterID' => $data['pilotID'],
                                'characterName' => $data['pilotName']
                            ]
                        ]);
                        ?>
                    </td>
                    <td>
                        <?php echo $data['shipClass']; ?>
                    </td>
                    <td>
                        <?php echo $data['system']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
