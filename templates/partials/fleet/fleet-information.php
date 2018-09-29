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
<div class="col-md-12">
    <header class="entry-header"><h2 class="entry-title"><?php echo \__('General Information', 'eve-online-intel-tool'); ?></h2></header>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
                <table class="table table-condensed">
                    <tr>
                        <td><?php echo \__('Fleetboss', 'eve-online-intel-tool'); ?></td>
                        <td class="data-align-right"><?php echo (!empty($fleetInformation['fleetBoss'])) ? $fleetInformation['fleetBoss'] : \__('Unknown', 'eve-online-intel-tool'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo \__('Pilots seen', 'eve-online-intel-tool'); ?></td>
                        <td class="data-align-right"><?php echo $pilotCount; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
                <table class="table table-condensed">
                    <tr>
                        <td><?php echo \__('Pilots docked', 'eve-online-intel-tool'); ?></td>
                        <td class="data-align-right"><?php echo (isset($fleetInformation['pilots']['docked']) && $fleetInformation['pilots']['docked'] !== '') ? $fleetInformation['pilots']['docked'] : \__('Unknown', 'eve-online-intel-tool'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo \__('Pilots in space', 'eve-online-intel-tool'); ?></td>
                        <td class="data-align-right"><?php echo (isset($fleetInformation['pilots']['inSpace']) && $fleetInformation['pilots']['inSpace'] !== '') ? $fleetInformation['pilots']['inSpace'] : \__('Unknown', 'eve-online-intel-tool'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
