<?php
defined('ABSPATH') or die();

// Meta data
$dscanDataAll = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-all', true));
$dscanDataOnGrid = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-onGrid', true));
$dscanDataOffGrid = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-offGrid', true));
$dscanDataShipTypes = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-shipTypes', true));
$dscanDataSystem = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-system', true));
$dscanDataTime = \get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-time', true);

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
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('All', 'eve-online-intel-tool'); ?> (<?php echo $countAll; ?>)</h2></header>
					<?php
					if(!empty($countAll)) {
						foreach($dscanDataAll['data'] as $data) {
							?>
							<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" title="<?php echo $data['shipClass']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
								<span class="dscan-ship-image">
									<?php
									$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('inventory') . $data['itemID'] . '_32.png');
									?>
									<img src="<?php echo $image; ?>" alt="<?php echo $data['type']; ?>" width="32" heigh="32">
								</span>
								<span class="dscan-ship-count"><?php echo $data['count']; ?></span>
								<span class="dscan-ship-type"><?php echo $data['type']; ?></span>
							</div>
							<?php
						} // END foreach($dscanDataAll['data'] as $data)
					} // END if(!empty($dscanDataAll['count']))
					?>
				</div>

				<!--
				// On Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('On Grid', 'eve-online-intel-tool'); ?> (<?php echo $countOnGrid; ?>)</h2></header>
					<?php
					if(!empty($countOnGrid)) {
						foreach($dscanDataOnGrid['data'] as $data) {
							?>
							<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" title="<?php echo $data['shipClass']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
								<span class="dscan-ship-image">
									<?php
									$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('inventory') . $data['itemID'] . '_32.png');
									?>
									<img src="<?php echo $image; ?>" alt="<?php echo $data['type']; ?>" width="32" heigh="32">
								</span>
								<span class="dscan-ship-count"><?php echo $data['count']; ?></span>
								<span class="dscan-ship-type"><?php echo $data['type']; ?></span>
							</div>
							<?php
						} // END foreach($dscanDataOnGrid['data'] as $data)
					} // END if(!empty($dscanDataOnGrid['count']))
					?>
				</div>

				<!--
				// Off Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Off Grid', 'eve-online-intel-tool'); ?> (<?php echo $countOffGrid; ?>)</h2></header>
					<?php
					if(!empty($countOffGrid)) {
						foreach($dscanDataOffGrid['data'] as $data) {
							?>
							<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" title="<?php echo $data['shipClass']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
								<span class="dscan-ship-image">
									<?php
									$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('inventory') . $data['itemID'] . '_32.png');
									?>
									<img src="<?php echo $image; ?>" alt="<?php echo $data['type']; ?>" width="32" heigh="32">
								</span>
								<span class="dscan-ship-count"><?php echo $data['count']; ?></span>
								<span class="dscan-ship-type"><?php echo $data['type']; ?></span>
							</div>
							<?php
						} // END foreach($dscanDataOffGrid['data'] as $data)
					} // END if(!empty($dscanDataOffGrid['count']))
					?>
				</div>

				<!--
				// Ship Types D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-types',[
						'shipTypeList' => $dscanDataShipTypes
					]);
					?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		function dscanHighlightShipClass(shipClass) {
			jQuery("div[data-typeclass='" + shipClass + "']").addClass('highlightShipClass');
		} // END function dscanHighlightShipClass(shipClass)

		function dscanDisableHighlightShipClass(shipClass) {
			jQuery("div[data-typeclass='" + shipClass + "']").removeClass('highlightShipClass');
		} // END function dscanDisableHighlightShipClass(shipClass)
		</script>
	</section>
</article><!-- /.post-->
