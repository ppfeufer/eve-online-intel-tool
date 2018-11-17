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
<header class="entry-header"><h2 class="entry-title"><?php echo $title; ?><?php if(isset($count)) {echo ' (' . $count . ')';} ?></h2></header>

<?php
if(\is_array($structures) && \count($structures) > 0) {
    ?>
    <div class="table-responsive table-eve-intel-upwell-structures table-eve-intel">
        <table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Structure Type', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($structures as $data) {
                ?>
                <tr data-highlight="shiptype-<?php echo $data['shipTypeSanitized']; ?>">
                    <td>
                        <?php
                        TemplateHelper::getInstance()->getTemplate('partials/ship/ship-image', [
                            'data' => [
                                'shipID' => $data['type_id'],
                                'shipName' => $data['type']
                            ]
                        ]);

                        echo $data['type'];
                        ?>
                    </td>
                    <td class="table-data-count"><?php echo $data['count']; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
