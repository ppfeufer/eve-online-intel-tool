<header class="entry-header"><h2 class="entry-title"><?php echo $title; ?><?php if(isset($count)) {echo ' (' . $count . ')';} ?></h2></header>

<?php
if(\is_array($structures) && \count($structures) > 0) {
    ?>
    <div class="table-responsive table-eve-intel-upwell-structures table-eve-intel">
        <table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
            <thead>
                <th><?php echo \__('Structure Type', 'eve-online-intel-tool'); ?></th>
                <th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
            </thead>
            <?php
            foreach($structures as $data) {
                ?>
                <tr data-highlight="shiptype-<?php echo $data['shipTypeSanitized']; ?>">
                    <td>
                        <?php
                        \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/ship/ship-image', [
                            'data' => [
                                'shipID' => $data['type_id'],
                                'shipName' => $data['type']
                            ],
                            'pluginSettings' => $pluginSettings
                        ]);

                        echo $data['type'];
                        ?>
                    </td>
                    <td class="table-data-count"><?php echo $data['count']; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
}
