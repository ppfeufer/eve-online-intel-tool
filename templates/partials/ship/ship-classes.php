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
if(\is_array($shipClassList) && \count($shipClassList) > 0) {
    ?>
    <div class="table-responsive table-eve-intel-shipclasses table-eve-intel">
        <table class="table table-sortable table-condensed" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Ship Class', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($shipClassList as $data) {
                ?>
                <tr data-highlight="shiptype-<?php echo $data['shipTypeSanitized']; ?>">
                    <td>
                        <?php
                        TemplateHelper::getTemplate('partials/ship/ship-image', [
                            'data' => $data
                        ]);

                        echo $data['shipName'];
                        ?>
                    </td>
                    <td class="table-data-count">
                        <?php echo $data['count']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
