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

?>
<div class="paste-explanation">
    <header class="entry-header">
        <h2 class="entry-title"><?php echo \__('Current ESI Status', 'eve-online-intel-tool'); ?></h2>
    </header>

    <table class="table table-condensed table-esi-status">
        <tr class="esi-status-green-endpoints">
            <td><?php echo \__('Green Endpoints', 'eve-online-intel-tool'); ?></td>
            <td class="data-align-right esi-status-percentage"><span class="loaderImage"></span></td>
        </tr>

        <tr class="esi-status-yellow-endpoints">
            <td><?php echo \__('Yellow Endpoints', 'eve-online-intel-tool'); ?></td>
            <td class="data-align-right esi-status-percentage"><span class="loaderImage"></span></td>
        </tr>

        <tr class="esi-status-red-endpoints">
            <td><?php echo \__('Red Endpoints', 'eve-online-intel-tool'); ?></td>
            <td class="data-align-right esi-status-percentage"><span class="loaderImage"></span></td>
        </tr>

        <tr class="esi-status-progress-bar">
            <td colspan="2">
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: 0%"></div>
                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width: 0%"></div>
                    <div class="progress-bar progress-bar-danger" role="progressbar" style="width: 0%"></div>
                </div>
                <small>
                    <?php echo \__('The more yellow or red endpoints, the more likely it is that parsing might fail.', 'eve-online-intel-tool'); ?><br>
                    (<a href="?show=esiStatus"><?php echo \__('Show current ESI status details', 'eve-online-intel-tool'); ?></a>)
                </small>
            </td>
        </tr>
    </table>
</div>
