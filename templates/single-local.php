<?php
\defined('ABSPATH') or die();
?>

<header class="page-title">
    <h1>
        <?php echo \__('Chat Scan', 'eve-online-intel-tool'); ?>
    </h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime'] . '</small>';
    }

    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-local'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <div class="local-scan-result row">
                <div class="col-md-6 col-lg-3">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/alliance-participation',[
                        'allianceCount' => \count($intelData['localDataAllianceList']),
                        'allianceParticipation' => $intelData['localDataAllianceParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <div class="col-md-6 col-lg-3">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/corporation-participation',[
                        'corporationCount' => \count($intelData['localDataCorporationList']),
                        'corporationParticipation' => $intelData['localDataCorporationParticipation'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>

                <div class="col-md-12 col-lg-6">
                    <?php
                    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/pilot-participation',[
                        'pilotCount' => \count($intelData['localDataPilotList']),
                        'pilotParticipation' => $intelData['localDataPilotDetails'],
                        'pluginSettings' => $pluginSettings
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>
</article><!-- /.post-->
