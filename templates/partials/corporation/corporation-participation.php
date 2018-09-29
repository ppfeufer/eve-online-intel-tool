<header class="entry-header"><h2 class="entry-title"><?php echo \__('Corporations Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $corporationCount; ?>)</h2></header>
<?php
if(!empty($corporationParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
        <table class="table table-condensed table-sortable eve-intel-corporation-participation-list" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Corporation Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($corporationParticipation as $corporationList) {
                foreach($corporationList as $corporation) {
                    ?>
                    <tr class="eve-intel-corporation-participation-item eve-intel-alliance-id-<?php echo $corporation['allianceID']; ?> eve-intel-corporation-id-<?php echo $corporation['corporationID']; ?>" data-highlight="alliance-<?php echo $corporation['allianceID']; ?>">
                        <td>
                            <?php
                            \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/corporation/corporation-logo', [
                                'data' => $corporation,
                                'pluginSettings' => $pluginSettings
                            ]);

                            \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/corporation/corporation-information', [
                                'data' => $corporation
                            ]);
                            ?>
                        </td>
                        <td class="table-data-count">
                            <?php echo $corporation['count']; ?>
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
