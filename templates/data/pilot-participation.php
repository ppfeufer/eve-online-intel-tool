<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $pilotCount; ?>)</h2></header>
<?php
if(!empty($pilotParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-pilots table-eve-intel">
		<table class="table table-sortable table-condensed table-pilot-participation">
			<thead>
				<th><?php echo \__('Name', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Alliance', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Corporation', 'eve-online-intel-tool'); ?></th>
			</thead>
			<?php
			foreach($pilotParticipation as $pilot) {
				if(!isset($pilot['allianceID'])) {
					$pilot['allianceID'] = null;
				} // END if(!isset($pilot['allianceID']))
				?>
				<tr data-highlight="alliance-<?php echo $pilot['allianceID']; ?>">
					<td>
						<?php
//						$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $pilot['characterID'] . '_32.jpg';
						$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-pilot.jpg');

						$jsonDataPilot = \json_encode([
							'entityType' => 'character',
							'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $pilot['characterID'] . '_32.jpg',
							'eveID' => $pilot['characterID']
						]);
						?>

						<script type="text/javascript">
							if((eveImages instanceof Array) === false) {
								var eveImages = [];
							} // if((eveImages instanceof Array) === false)

							eveImages.push(<?php echo $jsonDataPilot; ?>);
						</script>

						<img data-eveid="<?php echo $pilot['characterID']; ?>" src="<?php echo $imagePilot; ?>" alt="<?php echo $pilot['characterName']; ?>" width="32" heigh="32">
						<?php echo $pilot['characterName']; ?>
					</td>

					<td>
						<?php
						if(isset($pilot['allianceID'])) {
//							$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $pilot['allianceID'] . '_32.png';
							$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-alliance.png');

							$jsonDataAlliance = \json_encode([
								'entityType' => 'alliance',
								'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $pilot['allianceID'] . '_32.png',
								'eveID' => $pilot['allianceID']
							]);
							?>

							<script type="text/javascript">
								if((eveImages instanceof Array) === false) {
									var eveImages = [];
								} // if((eveImages instanceof Array) === false)

								eveImages.push(<?php echo $jsonDataAlliance; ?>);
							</script>

							<img data-eveid="<?php echo $pilot['allianceID']; ?>" src="<?php echo $imageAlliance; ?>" alt="<?php echo $pilot['allianceName']; ?>" title="<?php echo $pilot['allianceName']; ?>" width="32" heigh="32">
							<?php echo $pilot['allianceTicker']; ?>
							<?php
						} // END if(isset($pilot['characterData']->alliance_id))
						?>
					</td>

					<td>
						<?php
//						$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $pilot['corporationID'] . '_32.png';
						$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-corporation.png');

						$jsonDataAlliance = \json_encode([
							'entityType' => 'corporation',
							'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $pilot['corporationID'] . '_32.png',
							'eveID' => $pilot['corporationID']
						]);
						?>

						<script type="text/javascript">
							if((eveImages instanceof Array) === false) {
								var eveImages = [];
							} // if((eveImages instanceof Array) === false)

							eveImages.push(<?php echo $jsonDataAlliance; ?>);
						</script>

						<img data-eveid="<?php echo $pilot['corporationID']; ?>" src="<?php echo $imageCorporation; ?>" alt="<?php echo $pilot['corporationName']; ?>" title="<?php echo $pilot['corporationName']; ?>" width="32" heigh="32">
						<?php echo $pilot['corporationTicker']; ?>
					</td>
				</tr>
				<?php
			} // END foreach($localDataPilotDetails as $pilot)
			?>
		</table>
	</div>
	<?php
} // END if(!empty($localDataPilotDetails))
