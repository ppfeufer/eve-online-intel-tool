<?php
$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $data['characterID'] . '_32.jpg';

if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
	$lazyLoading = false;

	/**
	 * If lazy loading is used and the image
	 * cache is no longer valid
	 */
	if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('character', $data['characterID'] . '_32.jpg') === false) {
		$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-pilot.jpg');

		$jsonDataPilot = \json_encode([
			'entityType' => 'character',
			'imageUri' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $data['characterID'] . '_32.jpg',
			'eveID' => $data['characterID']
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
	} // if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('character', $data['characterID'] . '_32.jpg') === false)

	/**
	 * If lazy loading is not used or the image cache
	 * is still valid load the image directly
	 */
	if($lazyLoading === false) {
		$imagePilot = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('character', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('character') . $data['characterID'] . '_32.jpg');
	} // if($lazyLoading === false)
} // if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes')
?>

<img data-eveid="<?php echo $data['characterID']; ?>" data-pilotname="<?php echo $data['characterName']; ?>" src="<?php echo $imagePilot; ?>" alt="<?php echo $data['characterName']; ?>" width="32" heigh="32">
