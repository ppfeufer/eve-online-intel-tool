<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$imageAlliance = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png';

if(isset($pluginSettings['image-cache']['yes']) && $pluginSettings['image-cache']['yes'] === 'yes') {
    $lazyLoading = false;

    /**
     * If lazy loading is used and the image
     * cache is no longer valid
     */
    if(isset($pluginSettings['image-lazy-load']['yes']) && $pluginSettings['image-lazy-load']['yes'] === 'yes' && \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\CacheHelper::getInstance()->checkCachedImage('alliance', $data['allianceID'] . '_32.png') === false) {
        $imageAlliance = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('images/dummy-alliance.png');

        $jsonDataAlliance = \json_encode([
            'entityType' => 'alliance',
            'imageUri' => \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png',
            'eveID' => $data['allianceID']
        ]);
        ?>

        <script type="text/javascript">
            if((eveImages instanceof Array) === false) {
                var eveImages = [];
            }

            eveImages.push(<?php echo $jsonDataAlliance; ?>);
        </script>

        <?php
        $lazyLoading = true;
    }

    /**
     * If lazy loading is not used or the image cache
     * is still valid load the image directly
     */
    if($lazyLoading === false) {
        $imageAlliance = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('alliance', \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png');
    }
}
?>

<span class="eve-intel-alliance-logo-wrapper"><img class="eve-image" data-eveid="<?php echo $data['allianceID']; ?>" src="<?php echo $imageAlliance; ?>" alt="<?php echo $data['allianceName']; ?>" title="<?php echo $data['allianceName']; ?>" width="32" heigh="32"></span>
