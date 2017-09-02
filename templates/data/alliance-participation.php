<header class="entry-header"><h2 class="entry-title"><?php echo \__('Alliances Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $allianceCount; ?>)</h2></header>
<?php
if(!empty($allianceParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-alliances table-eve-intel">
		<table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
			<thead>
				<th><?php echo \__('Alliance Name', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
			</thead>
			<?php
			foreach($allianceParticipation as $allianceList) {
				foreach($allianceList as $alliance) {
					?>
					<tr data-highlight="alliance-<?php echo $alliance['allianceID']; ?>" onmouseover="dataHighlight('enable', 'alliance-<?php echo $alliance['allianceID']; ?>');" onmouseout="dataHighlight('disable', 'alliance-<?php echo $alliance['allianceID']; ?>');">
						<td>
							<?php
							$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $alliance['allianceID'] . '_32.png');
							?>
							<img src="<?php echo $image; ?>" alt="<?php echo $alliance['allianceName']; ?>" width="32" heigh="32">
							<?php echo $alliance['allianceName']; ?>
						</td>
						<td class="table-data-count">
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
