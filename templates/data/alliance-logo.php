<?php
$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png';

if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
	$lazyLoading = false;

	/**
	 * If lazy loading is used and the image
	 * cache is no longer valid
	 */
	if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('alliance', $data['allianceID'] . '_32.png') === false) {
		$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-alliance.png');

		$jsonDataAlliance = \json_encode([
			'entityType' => 'alliance',
			'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png',
			'eveID' => $data['allianceID']
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
	} // if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('alliance', $data['allianceID'] . '_32.jpg') === false)

	/**
	 * If lazy loading is not used or the image cache
	 * is still valid load the image directly
	 */
	if($lazyLoading === false) {
		$imageAlliance = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png');
	} // if($lazyLoading === false)
} // if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes')
?>

<img class="eve-image" data-eveid="<?php echo $data['allianceID']; ?>" data-alliancename="<?php echo $data['allianceName']; ?>" src="<?php echo $imageAlliance; ?>" alt="<?php echo $data['allianceName']; ?>" title="<?php echo $data['allianceName']; ?>" width="32" heigh="32">
