<header class="entry-header"><h2 class="entry-title"><?php echo \__('Corporations Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $corporationCount; ?>)</h2></header>
<?php
if(!empty($corporationParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
        <table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Corporation Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($corporationParticipation as $corporationList) {
                foreach($corporationList as $corporation) {
                    ?>
                    <tr data-highlight="alliance-<?php echo $corporation['allianceID']; ?>">
                        <td>
                            <?php
                            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/corporation/corporation-logo', [
                                'data' => $corporation,
                                'pluginSettings' => $pluginSettings
                            ]);
                            ?>

                            <span class="eve-intel-corporation-information-wrapper">
                                <span class="eve-intel-corporation-name-wrapper">
                                    <?php echo $corporation['corporationName']; ?>
                                </span>
                                <span class="eve-intel-corporation-links-wrapper">
                                    <small><a class="eve-intel-information-link" href="https://evemaps.dotlan.net/corp/<?php echo \str_replace(' ', '_', $corporation['corporationName']); ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/corporation/<?php echo $corporation['corporationName']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                                </span>
                            </span>
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
