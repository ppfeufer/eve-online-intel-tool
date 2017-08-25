<?php
defined('ABSPATH') or die();

$dscanDataAll = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-all', true));
$dscanDataOnGrid = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-onGrid', true));
$dscanDataOffGrid = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-offGrid', true));
$dscanDataShipTypes = \unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-shipTypes', true));
?>

<header class="page-title">
	<h1><?php echo \__('D-Scan', 'eve-online-intel-tool'); ?></h1>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="dscan-result row">
				<!--
				// Full D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('All', 'eve-online-intel-tool'); ?> (<?php echo $dscanDataAll['count']; ?>)</h2></header>
					<?php
					foreach($dscanDataAll['data'] as $data) {
						?>
						<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
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
					?>
				</div>

				<!--
				// On Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('On Grid', 'eve-online-intel-tool'); ?> (<?php echo $dscanDataOnGrid['count']; ?>)</h2></header>
					<?php
					foreach($dscanDataOnGrid['data'] as $data) {
						?>
						<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
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
					?>
				</div>

				<!--
				// Off Grid D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Off Grid', 'eve-online-intel-tool'); ?> (<?php echo $dscanDataOffGrid['count']; ?>)</h2></header>
					<?php
					foreach($dscanDataOffGrid['data'] as $data) {
						?>
						<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
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
					?>
				</div>

				<!--
				// Ship Class D-Scan Breakdown
				-->
				<div class="col-md-4 col-sm-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Classes', 'eve-online-intel-tool'); ?></h2></header>
					<?php
					foreach($dscanDataShipTypes as $data) {
						?>
						<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
							<span class="dscan-ship-count"><?php echo $data['count']; ?></span>
							<span class="dscan-ship-type"><?php echo $data['type']; ?></span>
						</div>
						<?php
					} // END foreach($dscanDataOffGrid['data'] as $data)
					?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
		function dscanHighlightShipClass(shipClass) {
			jQuery("div[data-typeclass='"+shipClass+"']").addClass('highlightShipClass');
		}

		function dscanDisableHighlightShipClass(shipClass) {
			jQuery("div[data-typeclass='"+shipClass+"']").removeClass('highlightShipClass');
		}
		</script>
	</section>
</article><!-- /.post-->
