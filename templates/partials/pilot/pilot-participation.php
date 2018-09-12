<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $pilotCount; ?>)</h2></header>
<?php
if(!empty($pilotParticipation)) {
    ?>
    <div class="table-responsive table-local-scan table-local-scan-pilots table-eve-intel">
        <table class="table table-sortable table-condensed table-pilot-participation" data-haspaging="no">
            <thead>
                <th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Alliance', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Corporation', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($pilotParticipation as $pilot) {
                if(!isset($pilot['allianceID'])) {
                    $pilot['allianceID'] = 0;
                }
                ?>
                <tr data-highlight="alliance-<?php echo $pilot['allianceID']; ?>">
                    <td>
                        <?php
                        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/pilot/pilot-avatar', [
                            'data' => $pilot,
                            'pluginSettings' => $pluginSettings
                        ]);
                        ?>

                        <span class="eve-intel-pilot-information-wrapper">
                            <span class="eve-intel-pilot-name-wrapper">
                                <?php echo $pilot['characterName']; ?>
                            </span>
                            <span class="eve-intel-pilot-links-wrapper">
                                <small><a class="eve-intel-information-link" href="https://evewho.com/pilot/<?php echo \urlencode($pilot['characterName']); ?>" target="_blank">evewho <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/character/<?php echo $pilot['characterName']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                            </span>
                        </span>
                    </td>

                    <td>
                        <?php
                        if(!\is_null($pilot['allianceID']) && $pilot['allianceID'] !== 0) {
                            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/alliance/alliance-logo', [
                                'data' => $pilot,
                                'pluginSettings' => $pluginSettings
                            ]);

                            echo $pilot['allianceTicker'];
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/corporation/corporation-logo', [
                            'data' => $pilot,
                            'pluginSettings' => $pluginSettings
                        ]);

                        echo $pilot['corporationTicker'];
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
