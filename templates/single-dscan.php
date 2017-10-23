<?php
defined('ABSPATH') or die();

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
		} // END if(!\is_null($systemName))
		?>
	</h1>

	<?php
	if(!empty($intelData['eveTime'])) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $intelData['eveTime'] . '</small>';
	} // END if(!empty($intelData['eveTime']))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="dscan-result row">
				<!--
				// Full D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
						'title' => \__('All', 'eve-online-intel-tool'),
						'count' => $countAll,
						'shipClassList' => (!empty($intelData['dscanDataAll']['data'])) ? $intelData['dscanDataAll']['data'] : null,
						'pluginSettings' => $pluginSettings
					]);
					?>
				</div>

				<!--
				// On Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
						'title' => \__('On Grid', 'eve-online-intel-tool'),
						'count' => $countOnGrid,
						'shipClassList' => (!empty($intelData['dscanDataOnGrid']['data'])) ? $intelData['dscanDataOnGrid']['data'] : null,
						'pluginSettings' => $pluginSettings
					]);
					?>
				</div>

				<!--
				// Off Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
						'title' => \__('Off Grid', 'eve-online-intel-tool'),
						'count' => $countOffGrid,
						'shipClassList' => (!empty($intelData['dscanDataOffGrid']['data'])) ? $intelData['dscanDataOffGrid']['data'] : null,
						'pluginSettings' => $pluginSettings
					]);
					?>
				</div>

				<!--
				// Ship Types D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-types',[
						'title' => \__('Ship Types', 'eve-online-intel-tool'),
						'shipTypeList' => $intelData['dscanDataShipTypes'],
						'pluginSettings' => $pluginSettings
					]);
					?>
				</div>
			</div>
		</div>
	</section>
</article><!-- /.post-->
