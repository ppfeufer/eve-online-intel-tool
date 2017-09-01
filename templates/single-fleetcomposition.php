<?php
defined('ABSPATH') or die();

// Meta data
$fleetOverview = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetOverview', true));
$fleetInformation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetInformation', true));

$shipClasses = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipClasses', true));
$shipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipTypes', true));

$pilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotList', true));
$pilotParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotDetails', true));

$corporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationList', true));
$corporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationParticipation', true));

$allianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceList', true));
$allianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceParticipation', true));

$fleetScanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-time', true));
?>

<header class="page-title">
	<h1>
		<?php echo \__('Fleet Composition', 'eve-online-intel-tool'); ?>
	</h1>

	<?php
	if(!empty($fleetScanDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $fleetScanDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="fleetcomposition-information row">
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
										<td class="data-align-right"><?php echo \count($pilotList); ?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="col-md-6 col-lg-3">
							<div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
								<table class="table table-condensed">
									<tr>
										<td><?php echo \__('Pilots docked', 'eve-online-intel-tool'); ?></td>
										<td class="data-align-right"><?php echo (!empty($fleetInformation['pilots']['docked'])) ? $fleetInformation['pilots']['docked'] : \__('Unknown', 'eve-online-intel-tool'); ?></td>
									</tr>
									<tr>
										<td><?php echo \__('Pilots in space', 'eve-online-intel-tool'); ?></td>
										<td class="data-align-right"><?php echo (!empty($fleetInformation['pilots']['inSpace'])) ? $fleetInformation['pilots']['inSpace'] : \__('Unknown', 'eve-online-intel-tool'); ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fleetcomposition-result row">
				<div class="col-md-6 col-lg-3">
					<?php
					if(\is_array($shipClasses) && \count($shipClasses)) {
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
							'title' => \__('Ship Classes', 'eve-online-intel-tool'),
							'shipClassList' => $shipClasses
						]);
					} // END if(\is_array($shipClasses) && \count($shipClasses))
					?>
				</div>

				<div class="col-md-6 col-lg-3">
					<?php
					if(\is_array($shipTypes) && \count($shipTypes)) {
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-types',[
							'title' => \__('Ship Types', 'eve-online-intel-tool'),
							'shipTypeList' => $shipTypes
						]);
					} // END if(\is_array($shipTypes) && \count($shipTypes))
					?>
				</div>
				<div class="col-md-12 col-lg-6">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Who is flying what', 'eve-online-intel-tool'); ?></h2></header>
					<?php
					if(\is_array($fleetOverview) && \count($fleetOverview)) {
						?>
						<div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-fleetinfo table-eve-intel">
							<table class="table table-sortable table-condensed">
								<thead>
									<th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
									<th><?php echo \__('Ship Class', 'eve-online-intel-tool'); ?></th>
									<th><?php echo \__('Where', 'eve-online-intel-tool'); ?></th>
								</thead>
								<?php
								foreach($fleetOverview as $data) {
									?>
									<tr>
										<td>
											<?php $imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('character', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $data['pilotID'] . '_32.jpg'); ?>
											<img src="<?php echo $imagePilot; ?>" alt="<?php echo $data['pilotName']; ?>" width="32" heigh="32">
											<?php echo $data['pilotName']; ?>
										</td>
										<td>
											<?php echo $data['shipClass']; ?>
										</td>
										<td>
											<?php echo $data['system']; ?>
										</td>
									</tr>
									<?php
								} // END foreach($fleetOverview as $data)
								?>
							</table>
						</div>
						<?php
					} // END if(\is_array($shipTypes) && \count($shipTypes))
					?>
				</div>
			</div>

			<div class="fleetcomposition-result row">
				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/alliance-participation',[
						'allianceCount' => \count($allianceList),
						'allianceParticipation' => $allianceParticipation
					]);
					?>
				</div>
				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/corporation-participation',[
						'corporationCount' => \count($corporationList),
						'corporationParticipation' => $corporationParticipation
					]);
					?>
				</div>
				<div class="col-md-12 col-lg-6">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/pilot-participation',[
						'pilotCount' => \count($pilotList),
						'pilotParticipation' => $pilotParticipation
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
