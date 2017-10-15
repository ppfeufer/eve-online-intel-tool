<header class="entry-header"><h2 class="entry-title"><?php echo \__('Corporations Breakdown', 'eve-online-intel-tool'); ?> (<?php echo $corporationCount; ?>)</h2></header>
<?php
if(!empty($corporationParticipation)) {
	?>
	<div class="table-responsive table-local-scan table-local-scan-corporation table-eve-intel">
		<table class="table table-condensed table-sortable" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
			<thead>
				<th><?php echo \__('Corporation Name', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
			</thead>
			<?php
			foreach($corporationParticipation as $corporationList) {
				foreach($corporationList as $corporation) {
					?>
					<tr data-highlight="alliance-<?php echo $corporation['allianceID']; ?>">
						<td>
							<?php
							$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $corporation['corporationID'] . '_32.png';

							if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
								$lazyLoading = false;

								/**
								 * If lazy loading is used and the image
								 * cache is no longer valid
								 */
								if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('corporation', $corporation['corporationID'] . '_32.png') === false) {
									$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-corporation.png');

									$jsonDataPilot = \json_encode([
										'entityType' => 'corporation',
										'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $corporation['corporationID'] . '_32.png',
										'eveID' => $corporation['corporationID']
									]);

									?>
									<script type="text/javascript">
										if((eveImages instanceof Array) === false) {
											var eveImages = [];
										} // if((eveImages instanceof Array) === false)


										eveImages.push(<?php echo $jsonDataPilot; ?>);
									</script>
									<?php

									$lazyLoading = true;
								} // if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('character', $corporation['characterID'] . '_32.jpg') === false)

								/**
								 * If lazy loading is not used or the image cache
								 * is still valid load the image directly
								 */
								if($lazyLoading === false) {
									$imageCorporation = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('corporation', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $corporation['corporationID'] . '_32.png');
								} // if($lazyLoading === false)
							} // if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes')
							?>
							<img data-eveid="<?php echo $corporation['corporationID']; ?>" src="<?php echo $imageCorporation; ?>" alt="<?php echo $corporation['corporationName']; ?>" title="<?php echo $corporation['corporationName']; ?>" width="32" heigh="32">
							<?php echo $corporation['corporationName']; ?>
						</td>
						<td class="table-data-count">
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
