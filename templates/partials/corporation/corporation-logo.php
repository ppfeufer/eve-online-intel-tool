<?php
$imageCorporation = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $data['corporationID'] . '_32.png';

if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
    $lazyLoading = false;

    /**
     * If lazy loading is used and the image
     * cache is no longer valid
     */
    if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('corporation', $data['corporationID'] . '_32.png') === false) {
        $imageCorporation = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-corporation.png');

        $jsonDataPilot = \json_encode([
            'entityType' => 'corporation',
            'imageUri' => \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $data['corporationID'] . '_32.png',
            'eveID' => $data['corporationID']
        ]);

        ?>
        <script type="text/javascript">
            if((eveImages instanceof Array) === false) {
                var eveImages = [];
            }

            eveImages.push(<?php echo $jsonDataPilot; ?>);
        </script>
        <?php

        $lazyLoading = true;
    }

    /**
     * If lazy loading is not used or the image cache
     * is still valid load the image directly
     */
    if($lazyLoading === false) {
        $imageCorporation = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('corporation', \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('corporation') . $data['corporationID'] . '_32.png');
    }
}
?>

<span class="eve-intel-corporation-logo-wrapper"><img class="eve-image" data-eveid="<?php echo $data['corporationID']; ?>" src="<?php echo $imageCorporation; ?>" alt="<?php echo $data['corporationName']; ?>" title="<?php echo $data['corporationName']; ?>" width="32" heigh="32"></span>
