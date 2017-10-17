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
					<tr data-highlight="alliance-<?php echo $alliance['allianceID']; ?>">
						<td>
							<?php
							$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $alliance['allianceID'] . '_32.png';

							if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
								$lazyLoading = false;

								/**
								 * If lazy loading is used and the image
								 * cache is no longer valid
								 */
								if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('alliance', $alliance['allianceID'] . '_32.png') === false) {
									$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-alliance.png');

									$jsonDataAlliance = \json_encode([
										'entityType' => 'alliance',
										'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $alliance['allianceID'] . '_32.png',
										'eveID' => $alliance['allianceID']
									]);

									?>
									<script type="text/javascript">
										if((eveImages instanceof Array) === false) {
											var eveImages = [];
										} // if((eveImages instanceof Array) === false)

										eveImages.push(<?php echo $jsonDataAlliance; ?>);
									</script>
									<?php

									$lazyLoading = true;
								} // if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('alliance', $alliance['allianceID'] . '_32.jpg') === false)

								/**
								 * If lazy loading is not used or the image cache
								 * is still valid load the image directly
								 */
								if($lazyLoading === false) {
									$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $alliance['allianceID'] . '_32.png');
								} // if($lazyLoading === false)
							} // if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes')
							?>
							<img data-eveid="<?php echo $alliance['allianceID']; ?>" src="<?php echo $imageAlliance; ?>" alt="<?php echo $alliance['allianceName']; ?>" title="<?php echo $alliance['allianceName']; ?>" width="32" heigh="32">
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
