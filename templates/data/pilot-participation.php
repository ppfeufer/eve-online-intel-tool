<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $pilotCount; ?>)</h2></header>
<?php
if(!empty($pilotParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-pilots table-eve-intel">
		<table class="table table-sortable table-condensed">
			<thead>
				<th>Name</th>
				<th>Alliance</th>
				<th>Corporation</th>
			</thead>
			<?php
			foreach($pilotParticipation as $pilot) {
				?>
				<tr>
					<td>
						<?php
						$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('character', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $pilot['characterID'] . '_32.jpg');
						?>
						<img src="<?php echo $imagePilot; ?>" alt="<?php echo $pilot['characterName']; ?>" width="32" heigh="32">
						<?php echo $pilot['characterName']; ?>
					</td>

					<td>
						<?php
						if(isset($pilot['allianceID'])) {
							$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $pilot['allianceID'] . '_32.png');
							?>
							<img src="<?php echo $imageAlliance; ?>" alt="<?php echo $pilot['allianceName']; ?>" title="<?php echo $pilot['allianceName']; ?>" width="32" heigh="32">
							<?php echo $pilot['allianceTicker']; ?>
							<?php
						} // END if(isset($pilot['characterData']->alliance_id))
						?>
					</td>

					<td>
						<?php
						$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('corporation', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $pilot['corporationID'] . '_32.png');
						?>
						<img src="<?php echo $imageCorporation; ?>" alt="<?php echo $pilot['corporationName']; ?>" title="<?php echo $pilot['corporationName']; ?>" width="32" heigh="32">
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
