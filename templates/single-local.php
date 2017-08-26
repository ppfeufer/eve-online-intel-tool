<?php
defined('ABSPATH') or die();

$localDataPilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotList', true));
$localDataPilotDetails = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotDetails', true), [false]);
$localDataCorporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationList', true));
$localDataCorporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationParticipation', true));
$localDataAllianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceList', true));
$localDataAllianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceParticipation', true));
$localDataTime = \get_post_meta(\get_the_ID(), 'eve-intel-tool_local-time', true);
?>

<header class="page-title">
	<h1>
		<?php
		echo \__('Chat Scan', 'eve-online-intel-tool');
		?>
	</h1>

	<?php
	if(!empty($localDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $localDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-content-fitting'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="local-scan-result row">
				<div class="col-md-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Alliances Breakdown', 'eve-online-intel-tool'); ?> (<?php echo \count($localDataAllianceList); ?>)</h2></header>
					<?php
					if(!empty($localDataAllianceParticipation)) {
						?>
						<div class="table-responsive table-local-scan table-local-scan-alliances">
							<table class="table table-condensed">
								<?php
								foreach($localDataAllianceParticipation as $allianceList) {
									foreach($allianceList as $alliance) {
										?>
										<tr>
											<td>
												<?php
												$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $alliance['allianceID'] . '_32.png');
												?>
												<img src="<?php echo $image; ?>" alt="<?php echo $alliance['allianceName']; ?>" width="32" heigh="32">
												<?php echo $alliance['allianceName']; ?>
											</td>
											<td>
												<?php echo $alliance['count']; ?>
											</td>
										</tr>
										<?php
									} // END foreach($allianceList as $alliance)
								} // END foreach($localDataAllianceParticipation as $allianceList)
								?>
							</table>
						</div>
						<?php
					} // END if(!empty($localDataAllianceParticipation))
					?>
				</div>

				<div class="col-md-6 col-lg-3">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Corporations Breakdown', 'eve-online-intel-tool'); ?> (<?php echo \count($localDataCorporationList); ?>)</h2></header>
					<?php
					if(!empty($localDataCorporationParticipation)) {
						?>
						<div class="table-responsive table-local-scan table-local-scan-corporation">
							<table class="table table-condensed">
								<?php
								foreach($localDataCorporationParticipation as $corporationList) {
									foreach($corporationList as $corporation) {
										?>
										<tr>
											<td>
												<?php
												$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('corporation', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $corporation['corporationID'] . '_32.png');
												?>
												<img src="<?php echo $image; ?>" alt="<?php echo $corporation['corporationName']; ?>" width="32" heigh="32">
												<?php echo $corporation['corporationName']; ?>
											</td>
											<td>
												<?php echo $corporation['count']; ?>
											</td>
										</tr>
										<?php
									} // END foreach($corporationList as $corporation)
								} // END foreach($localDataCorporationParticipation as $corporationList)
								?>
							</table>
						</div>
						<?php
					} // END if(!empty($localDataCorporationParticipation))
					?>
				</div>

				<div class="col-md-12 col-lg-6">
					<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo \count($localDataPilotList); ?>)</h2></header>
					<?php
					if(!empty($localDataPilotDetails)) {
						?>
						<div class="table-responsive table-local-scan table-local-scan-pilots">
							<table class="table table-condensed">
								<thead>
									<th>Name</th>
									<th>Alliance</th>
									<th>Corporation</th>
								</thead>
								<?php
								foreach($localDataPilotDetails as $pilot) {
									?>
									<tr>
										<td>
											<?php
											$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('character', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $pilot['characterID'] . '_32.jpg');
											?>
											<img src="<?php echo $imagePilot; ?>" alt="<?php echo $pilot['name']; ?>" width="32" heigh="32">
											<?php echo $pilot['name']; ?>
										</td>

										<td>
											<?php
											if(isset($pilot['characterData']->alliance_id)) {
												$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $pilot['characterData']->alliance_id . '_32.png');
												?>
												<img src="<?php echo $imageAlliance; ?>" alt="<?php echo $pilot['allianceData']->alliance_name; ?>" title="<?php echo $pilot['allianceData']->alliance_name; ?>" width="32" heigh="32">
													<?php echo $pilot['allianceData']->ticker; ?>
												<?php
											} // END if(isset($pilot['characterData']->alliance_id))
											?>
										</td>

										<td>
											<?php
											$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('corporation', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $pilot['characterData']->corporation_id . '_32.png');
											?>
											<img src="<?php echo $imageCorporation; ?>" alt="<?php echo $pilot['allianceData']->alliance_name; ?>" title="<?php echo $pilot['corporationData']->corporation_name; ?>" width="32" heigh="32">
												<?php echo $pilot['corporationData']->ticker; ?>
										</td>
									</tr>
									<?php
								} // END foreach($localDataPilotDetails as $pilot)
								?>
							</table>
						</div>
						<?php
					} // END if(!empty($localDataPilotDetails))
					?>
				</div>
			</div>
		</div>
	</section>
</article><!-- /.post-->
