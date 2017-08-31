<?php
defined('ABSPATH') or die();

// Meta data
$dscanDataAll = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-all', true));
$dscanDataOnGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-onGrid', true));
$dscanDataOffGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-offGrid', true));

$dscanDataShipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-shipTypes', true));
$dscanDataSystem = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-system', true));

$dscanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-time', true));

// Counter
$countAll = (!empty($dscanDataAll['count'])) ? $dscanDataAll['count'] : 0;
$countOnGrid = (!empty($dscanDataOnGrid['count'])) ? $dscanDataOnGrid['count'] : 0;
$countOffGrid = (!empty($dscanDataOffGrid['count'])) ? $dscanDataOffGrid['count'] : 0;

// System data
$systemName = (!empty($dscanDataSystem['systemName'])) ? $dscanDataSystem['systemName'] : null;
$constellationName = (!empty($dscanDataSystem['constellationName'])) ? $dscanDataSystem['constellationName'] : null;
$regionName = (!empty($dscanDataSystem['regionName'])) ? $dscanDataSystem['regionName'] : null;
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
	if(!empty($dscanDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $dscanDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

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
						'shipClassList' => (!empty($dscanDataAll['data'])) ? $dscanDataAll['data'] : null
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
						'shipClassList' => (!empty($dscanDataOnGrid['data'])) ? $dscanDataOnGrid['data'] : null
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
						'shipClassList' => (!empty($dscanDataOffGrid['data'])) ? $dscanDataOffGrid['data'] : null
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
						'shipTypeList' => $dscanDataShipTypes
					]);
					?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		function dscanHighlightShipClass(shipClass) {
			jQuery("tr[data-typeclass='" + shipClass + "']").addClass('highlightShipClass');
		} // END function dscanHighlightShipClass(shipClass)

		function dscanDisableHighlightShipClass(shipClass) {
			jQuery("tr[data-typeclass='" + shipClass + "']").removeClass('highlightShipClass');
		} // END function dscanDisableHighlightShipClass(shipClass)
		</script>
	</section>
</article><!-- /.post-->
