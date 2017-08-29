<header class="entry-header"><h2 class="entry-title"><?php echo \__('Alliances Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $allianceCount; ?>)</h2></header>
<?php
if(!empty($allianceParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-alliances">
		<table class="table table-condensed">
			<?php
			foreach($allianceParticipation as $allianceList) {
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
} // END if(!empty($localDataAllianceParticipation)
