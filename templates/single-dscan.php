<?php
\defined('ABSPATH') or die();

// Counter
$countAll = (!empty($intelData['dscanDataAll']['count'])) ? $intelData['dscanDataAll']['count'] : 0;
$countOnGrid = (!empty($intelData['dscanDataOnGrid']['count'])) ? $intelData['dscanDataOnGrid']['count'] : 0;
$countOffGrid = (!empty($intelData['dscanDataOffGrid']['count'])) ? $intelData['dscanDataOffGrid']['count'] : 0;

// System data
$systemName = (!empty($intelData['dscanDataSystem']['systemName'])) ? $intelData['dscanDataSystem']['systemName'] : null;
$constellationName = (!empty($intelData['dscanDataSystem']['constellationName'])) ? $intelData['dscanDataSystem']['constellationName'] : null;
$regionName = (!empty($intelData['dscanDataSystem']['regionName'])) ? $intelData['dscanDataSystem']['regionName'] : null;
?>

<header class="page-title">
    <h1>
        <?php
        echo \__('D-Scan', 'eve-online-intel-tool');

        if(!\is_null($systemName)) {
            echo '<br><small>' . \__('Solar System:', 'eve-online-intel-tool') . ' ' . $systemName . '</small>';

            if(!\is_null($constellationName)) {
                echo '<small> - ' . $constellationName . '</small>';
            }

            if(!\is_null($regionName)) {
                echo '<small> - ' . $regionName . '</small>';
            }
        }
        ?>
    </h1>

    <?php
    if(!empty($intelData['eveTime'])) {
        echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime'] . '</small>';
    }

    \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/extra/buttons');
    ?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <?php
            /**
             * D-Scan Breakdown
             */
            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/dscan/dscan-breakdown', [
                'countAll' => $countAll,
                'countOnGrid' => $countOnGrid,
                'countOffGrid' => $countOffGrid,
                'intelData' => $intelData,
                'pluginSettings' => $pluginSettings
            ]);

            /**
             * Interesting on grid
             */
            if(!empty($intelData['dscanUpwellStructures']) || !empty($intelData['dscanDeployables'])) {
                \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/dscan/interesting-on-grid-breakdown', [
                    'countAll' => $countAll,
                    'countOnGrid' => $countOnGrid,
                    'countOffGrid' => $countOffGrid,
                    'intelData' => $intelData,
                    'pluginSettings' => $pluginSettings
                ]);
            }
            ?>
        </div>
    </section>
</article><!-- /.post-->
