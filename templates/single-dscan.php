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
    <h1><?php echo \__('D-Scan', 'eve-online-intel-tool'); ?></h1>

    <?php
    if(!\is_null($systemName)) {
        ?>
        <div class="eve-intel-dscan-system-header row">
            <div class="col-md-4">
                <p>
                    <?php echo \__('Solar System:', 'eve-online-intel-tool') . ' ' . $systemName; ?><br>
                    <small><a href="https://evemaps.dotlan.net/map/<?php echo $regionName; ?>/<?php echo $systemName; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/system/<?php echo $systemName; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                </p>
            </div>
            <?php
            if(!\is_null($constellationName)) {
                ?>
                <div class="col-md-4">
                    <p>
                        <?php echo \__('Constellation:', 'eve-online-intel-tool') . ' ' . $constellationName; ?><br>
                        <small><a href="https://evemaps.dotlan.net/map/<?php echo $regionName; ?>/<?php echo $constellationName; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/constellation/<?php echo $constellationName; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                    </p>
                </div>
                <?php
            }

            if(!\is_null($regionName)) {
                ?>
                <div class="col-md-4">
                    <p>
                        <?php echo \__('Region:', 'eve-online-intel-tool') . ' ' . $regionName; ?><br>
                        <small><a href="https://evemaps.dotlan.net/map/<?php echo $regionName; ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a></small> | <small><a href="https://zkillboard.com/region/<?php echo $regionName; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }

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
