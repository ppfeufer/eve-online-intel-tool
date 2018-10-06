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
// System Information
-->
<div class="col-md-6 col-lg-4">
    <header class="entry-header"><h2 class="entry-title"><?php echo __('System Information', 'eve-online-intel-tool'); ?></h2></header>
    <div class="table-responsive table-dscan-scan table-dscan-system-information table-eve-intel">
        <table class="table table-condensed">
            <tr>
                <td>
                    <?php echo __('Solar System', 'eve-online-intel-tool'); ?>
                </td>
                <td class="data-align-right">

                    <?php echo $systemData['system']['name']; ?>
                    <small>
                        (<a href="https://evemaps.dotlan.net/map/<?php echo $systemData['region']['name']; ?>/<?php echo $systemData['system']['name']; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/system/<?php echo $systemData['system']['id']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>)
                    </small>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo __('Constellation', 'eve-online-intel-tool'); ?>
                </td>
                <td class="data-align-right">
                    <?php echo $systemData['constellation']['name']; ?>
                    <small>
                        (<a href="https://evemaps.dotlan.net/map/<?php echo $systemData['region']['name']; ?>/<?php echo $systemData['constellation']['name']; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/constellation/<?php echo $systemData['constellation']['id']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>)
                    </small>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo __('Region', 'eve-online-intel-tool'); ?>
                </td>
                <td class="data-align-right">
                    <?php echo $systemData['region']['name']; ?>
                    <small>
                        (<a href="https://evemaps.dotlan.net/map/<?php echo $systemData['region']['name']; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/region/<?php echo $systemData['region']['id']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>)
                    </small>
                </td>
            </tr>
        </table>
    </div>
</div>
