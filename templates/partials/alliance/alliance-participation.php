<header class="entry-header"><h2 class="entry-title"><?php echo \__('Alliances Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $allianceCount; ?>)</h2></header>
<?php
if(!empty($allianceParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-alliances table-eve-intel">
        <table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Alliance Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($allianceParticipation as $allianceList) {
                foreach($allianceList as $alliance) {
                    ?>
                    <tr data-highlight="alliance-<?php echo $alliance['allianceID']; ?>">
                        <td>
                            <?php
                            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/alliance/alliance-logo', [
                                'data' => $alliance,
                                'pluginSettings' => $pluginSettings
                            ]);

                            echo $alliance['allianceName'];
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
