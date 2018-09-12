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
