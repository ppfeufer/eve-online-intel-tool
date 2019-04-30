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
<header class="entry-header"><h2 class="entry-title"><?php echo \__('Alliances Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $allianceCount; ?>)</h2></header>
<?php
if(!empty($allianceParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-alliances table-eve-intel">
        <table class="table table-condensed table-sortable eve-intel-alliance-participation-list" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Alliance Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($allianceParticipation as $allianceList) {
                foreach($allianceList as $alliance) {
                    ?>
                    <tr class="eve-intel-alliance-participation-item eve-intel-alliance-id-<?php echo $alliance['allianceID']; ?>" data-alliance-id="<?php echo $alliance['allianceID']; ?>">
                        <td data-search="<?php echo $alliance['allianceName']; ?>, <?php echo $alliance['allianceTicker']; ?>">
                            <?php
                            $templateHelper->getTemplate('partials/alliance/alliance-logo', [
                                'data' => $alliance
                            ]);

                            $templateHelper->getTemplate('partials/alliance/alliance-information', [
                                'data' => $alliance
                            ]);
                            ?>
                        </td>
                        <td class="table-data-count">
                            <?php echo $alliance['count']; ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <?php
}
