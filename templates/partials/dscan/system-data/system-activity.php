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

?>

<!--
// System Activity
-->
<div class="col-md-6 col-lg-4">
    <div class="table-responsive table-dscan-scan table-dscan-system-information table-eve-intel">
        <header class="entry-header"><h2 class="entry-title"><?php echo \__('System Activity', 'eve-online-intel-tool'); ?> <small>(<?php echo \__('At the time of this D-Scan', 'eve-online-intel-tool'); ?>)</small></h2></header>
        <table class="table table-condensed">
            <tr>
                <td><?php echo \__('Jumps', 'eve-online-intel-tool'); ?> <small><?php echo \__('(last hour)', 'eve-online-intel-tool'); ?></small></td>
                <td class="data-align-right"><?php echo $systemData['activity']['jumps']; ?></td>
            </tr>
            <tr>
                <td><?php echo \__('NPC Kills', 'eve-online-intel-tool'); ?> <small><?php echo \__('(last hour)', 'eve-online-intel-tool'); ?></small></td>
                <td class="data-align-right"><?php echo $systemData['activity']['npcKills']; ?></td>
            </tr>
            <tr>
                <td><?php echo \__('Ship Kills', 'eve-online-intel-tool'); ?> <small><?php echo \__('(last hour)', 'eve-online-intel-tool'); ?></small></td>
                <td class="data-align-right"><?php echo $systemData['activity']['shipKills']; ?></td>
            </tr>
            <tr>
                <td><?php echo \__('Pod Kills', 'eve-online-intel-tool'); ?> <small><?php echo \__('(last hour)', 'eve-online-intel-tool'); ?></small></td>
                <td class="data-align-right"><?php echo $systemData['activity']['podKills']; ?></td>
            </tr>
        </table>
    </div>
</div>
