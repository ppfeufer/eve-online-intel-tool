<header class="entry-header"><h2 class="entry-title"><?php echo \__('Who is flying what', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(\is_array($fleetOverview) && \count($fleetOverview)) {
    ?>
    <div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-fleetinfo table-eve-intel">
        <table class="table table-sortable table-condensed" data-haspaging="no">
            <thead>
                <th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Ship Class', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Where', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($fleetOverview as $data) {
                ?>
                <tr data-highlight="shiptype-<?php echo \sanitize_title($data['shipType']); ?>">
                    <td>
                        <?php
                        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/pilot/pilot-avatar', [
                            'data' => [
                                'characterID' => $data['pilotID'],
                                'characterName' => $data['pilotName']
                            ],
                            'pluginSettings' => $pluginSettings
                        ]);
                        ?>

                        <span class="eve-intel-pilot-information-wrapper">
                            <span class="eve-intel-pilot-name-wrapper">
                                <?php echo $data['pilotName']; ?>
                            </span>
                            <span class="eve-intel-pilot-links-wrapper">
                                <small><a class="eve-intel-information-link" href="https://evewho.com/pilot/<?php echo \urlencode($data['pilotName']); ?>" target="_blank">evewho <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/character/<?php echo $data['pilotID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                            </span>
                        </span>
                    </td>
                    <td>
                        <?php echo $data['shipClass']; ?>
                    </td>
                    <td>
                        <?php echo $data['system']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
