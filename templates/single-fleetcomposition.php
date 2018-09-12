<?php
\defined('ABSPATH') or die();
?>

<header class="page-title">
    <h1><?php echo \__('Fleet Composition', 'eve-online-intel-tool'); ?></h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        ?>
        <div><p><small><?php echo \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime']; ?></small></p></div>
        <?php
    }

    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <div class="fleetcomposition-information row">
                <!--
                // General fleet information
                -->
                <?php
                if(\is_array($intelData['shipTypes']) && \count($intelData['shipTypes'])) {
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/fleet/fleet-information', [
                        'pilotCount' => \count($intelData['pilotList']),
                        'fleetInformation' => $intelData['fleetInformation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                }
                ?>
            </div>

            <div class="fleetcomposition-result row">
                <!--
                // Ship class overview
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    if(\is_array($intelData['shipClasses']) && \count($intelData['shipClasses'])) {
                        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/ship/ship-classes', [
                            'title' => \__('Ship Classes', 'eve-online-intel-tool'),
                            'shipClassList' => $intelData['shipClasses'],
                            'pluginSettings' => $pluginSettings
                        ]);
                    }
                    ?>
                </div>

                <!--
                // Ship type overview
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    if(\is_array($intelData['shipTypes']) && \count($intelData['shipTypes'])) {
                        \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/ship/ship-types', [
                            'title' => \__('Ship Types', 'eve-online-intel-tool'),
                            'shipTypeList' => $intelData['shipTypes'],
                            'pluginSettings' => $pluginSettings
                        ]);
                    }
                    ?>
                </div>

                <!--
                // Who is flying what?
                -->
                <div class="col-md-12 col-lg-6">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/fleet/fleet-composition', [
                        'fleetOverview' => $intelData['fleetOverview'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>
            </div>

            <div class="fleetcomposition-result row">
                <!--
                // Alliance participation
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/alliance/alliance-participation', [
                        'allianceCount' => \count($intelData['allianceList']),
                        'allianceParticipation' => $intelData['allianceParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <!--
                // Corporation participation
                -->
                <div class="col-md-6 col-lg-3">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/corporation/corporation-participation', [
                        'corporationCount' => \count($intelData['corporationList']),
                        'corporationParticipation' => $intelData['corporationParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <!--
                // Pilots participation and breakdown to corporations and alliances
                -->
                <div class="col-md-12 col-lg-6">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/pilot/pilot-participation', [
                        'pilotCount' => \count($intelData['pilotList']),
                        'pilotParticipation' => $intelData['pilotParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>
</article><!-- /.post-->
