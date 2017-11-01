<header class="entry-header"><h2 class="entry-title"><?php echo \__('Pilots Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $pilotCount; ?>)</h2></header>
<?php
if(!empty($pilotParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-pilots table-eve-intel">
		<table class="table table-sortable table-condensed table-pilot-participation" data-haspaging="no">
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
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/pilot-avatar', [
							'data' => $pilot,
							'pluginSettings' => $pluginSettings
						]);

						echo $pilot['characterName'];
						?>
					</td>

					<td>
						<?php
						if(isset($pilot['allianceID'])) {
							\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/alliance-logo', [
								'data' => $pilot,
								'pluginSettings' => $pluginSettings
							]);

							echo $pilot['allianceTicker'];
						} // END if(isset($pilot['characterData']->alliance_id))
						?>
					</td>

					<td>
						<?php
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/corporation-logo', [
							'data' => $pilot,
							'pluginSettings' => $pluginSettings
						]);

						echo $pilot['corporationTicker'];
						?>
					</td>
				</tr>
				<?php
			} // END foreach($localDataPilotDetails as $pilot)
			?>
		</table>
	</div>
	<?php
} // END if(!empty($localDataPilotDetails))
