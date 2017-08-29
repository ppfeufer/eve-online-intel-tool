<?php
defined('ABSPATH') or die();

// Meta data
$fleetOverview = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetOverview', true));
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
	if(!empty($dscanDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $fleetScanDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="fleetcomposition-result row">
				<div class="col-md-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Classes', 'eve-online-intel-tool'); ?></h2></header>
					<?php
					if(\is_array($shipClasses) && \count($shipClasses)) {
						?>
						<div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-shipclasses">
							<table class="table table-condensed">
								<?php
								foreach($shipClasses as $ship) {
									?>
									<tr>
										<td>
											<?php
											$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('ship') . $ship['shipID'] . '_32.png');
											?>
											<img src="<?php echo $image; ?>" alt="<?php echo $ship['shipName']; ?>" width="32" heigh="32">
											<?php echo $ship['shipName']; ?>
										</td>
										<td>
											<?php echo $ship['count']; ?>
										</td>
									</tr>
									<?php
								} // END foreach($shipClasses as $ship)
								?>
							</table>
						</div>
						<?php
					} // END if(\is_array($shipClasses) && \count($shipClasses))
					?>
				</div>

				<div class="col-md-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Types', 'eve-online-intel-tool'); ?></h2></header>
					<?php
					if(\is_array($shipTypes) && \count($shipTypes)) {
						?>
						<div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-shiptypes">
							<table class="table table-condensed">
								<?php
								foreach($shipTypes as $ship) {
									?>
									<tr>
										<td>
											<?php echo $ship['name']; ?>
										</td>
										<td>
											<?php echo $ship['count']; ?>
										</td>
									</tr>
									<?php
								} // END foreach($shipTypes as $ship)
								?>
							</table>
						</div>
						<?php
					} // END if(\is_array($shipTypes) && \count($shipTypes))
					?>
				</div>
				<div class="col-md-12 col-lg-6">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Who is flying what', 'eve-online-intel-tool'); ?></h2></header>
					<?php
					if(\is_array($fleetOverview) && \count($fleetOverview)) {
						?>
						<div class="table-responsive table-fleetcomposition-scan table-fleetcomposition-scan-fleetinfo">
							<table class="table table-sortable table-condensed">
								<thead>
									<th>Name</th>
									<th>Ship Class</th>
									<th>Where</th>
								</thead>
								<?php
								foreach($fleetOverview as $data) {
									?>
									<tr>
										<td>
											<?php
											$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('character', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $data['pilotID'] . '_32.jpg');
											?>
											<img src="<?php echo $imagePilot; ?>" alt="<?php echo $data['pilotName']; ?>" width="32" heigh="32">
											<?php echo $data['pilotName']; ?>
										</td>
										<td>
											<?php
											echo $data['shipClass'];
											?>
										</td>
										<td>
											<?php
											echo $data['system'];
											?>
										</td>
									</tr>
									<?php
								}
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
	</section>
</article><!-- /.post-->
