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

?>

<!--
// System Status
-->
<div class="col-md-6 col-lg-4">
    <div class="table-responsive table-dscan-scan table-dscan-system-information table-eve-intel">
        <header class="entry-header"><h2 class="entry-title"><?php echo \__('System Status', 'eve-online-intel-tool'); ?></h2></header>
        <table class="table table-condensed">
            <tr>
                <td><?php echo \__('Security Status', 'eve-online-intel-tool'); ?></td>
                <td class="data-align-right"><?php echo $systemData['system']['securityStatus']; ?></td>
            </tr>
            <?php
            if(!is_null($systemData['system']['adm'])) {
                ?>
                <tr>
                    <td><?php echo \__('Activity Defense Multiplier', 'eve-online-intel-tool'); ?></td>
                    <td class="data-align-right"><?php echo $systemData['system']['adm']; ?></td>
                </tr>
                <?php
            }

            if(!is_null($systemData['system']['sovHolder'])) {
                ?>
                <tr>
                    <td>
                        <?php echo \__('Sov Holding Alliance', 'eve-online-intel-tool'); ?>
                    </td>
                    <td class="data-align-right">
                        <?php
                        TemplateHelper::getInstance()->getTemplate('partials/alliance/alliance-logo', [
                            'data' => [
                                'allianceID' => $systemData['system']['sovHolder']['alliance']['id'],
                                'allianceName' => $systemData['system']['sovHolder']['alliance']['name'],
                                'size' => 24
                            ]
                        ]);
                        echo $systemData['system']['sovHolder']['alliance']['name'];
                        ?>
                        <br>
                        <small>
                            <a href="https://evemaps.dotlan.net/alliance/<?php echo $systemData['system']['sovHolder']['alliance']['name']; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/alliance/<?php echo $systemData['system']['sovHolder']['alliance']['id']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>
                        </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo \__('Sov Holding Corporation', 'eve-online-intel-tool'); ?>
                    </td>
                    <td class="data-align-right">
                        <?php
                        TemplateHelper::getInstance()->getTemplate('partials/corporation/corporation-logo', [
                            'data' => [
                                'corporationID' => $systemData['system']['sovHolder']['corporation']['id'],
                                'corporationName' => $systemData['system']['sovHolder']['corporation']['name'],
                                'size' => 24
                            ]
                        ]);
                        echo $systemData['system']['sovHolder']['corporation']['name'];
                        ?>
                        <br>
                        <small>
                            <a href="https://evemaps.dotlan.net/corp/<?php echo $systemData['system']['sovHolder']['corporation']['name']; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/corporation/<?php echo $systemData['system']['sovHolder']['corporation']['id']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>
                        </small>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
