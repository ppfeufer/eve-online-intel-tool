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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

\defined('ABSPATH') or die();

/**
 * WP Filesystem API
 */
require_once(\ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
require_once(\ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');

class CacheHelper extends AbstractSingleton {
    /**
     * The base directoy of our cache
     *
     * @var string
     */
    private $cacheDirectoryBase;

    /**
     * Plugin Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper
     */
    private $pluginHelper = null;

    /**
     * Image Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper
     */
    private $imageHelper = null;

    /**
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper
     */
    private $remoteHelper = null;

    /**
     * Plugin Settings
     *
     * @var array
     */
    private $pluginSettings = null;

    /**
     * Constructor
     */
    protected function __construct() {
        parent::__construct();

        if(!$this->imageHelper instanceof \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper) {
            $this->imageHelper = ImageHelper::getInstance();
        }

        $this->remoteHelper = RemoteHelper::getInstance();

        if(!$this->pluginHelper instanceof \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper) {
            $this->pluginHelper = PluginHelper::getInstance();
            $this->pluginSettings = $this->pluginHelper->getPluginSettings();
        }

        $this->cacheDirectoryBase = $this->getPluginCacheDir();

        $this->checkOrCreateCacheDirectories();
    }

    /**
     * Check if cache directories exist, otherwise try to create them
     */
    public function checkOrCreateCacheDirectories() {
        $this->createCacheDirectory();
        $this->createCacheDirectory('esi');
        $this->createCacheDirectory('images');
        $this->createCacheDirectory('images/ship');
        $this->createCacheDirectory('images/character');
        $this->createCacheDirectory('images/corporation');
        $this->createCacheDirectory('images/alliance');
    }

    /**
     * Getting the absolute path for the cache directory
     *
     * @return string absolute path for the cache directory
     */
    public function getPluginCacheDir() {
        return \trailingslashit(\WP_CONTENT_DIR) . 'cache/eve-online/';
    }

    /**
     * Getting the URI for the cache directory
     *
     * @return string URI for the cache directory
     */
    public function getPluginCacheUri() {
        return \trailingslashit(\WP_CONTENT_URL) . 'cache/eve-online/';
    }

    /**
     * Getting the local image cache directory
     *
     * @return string Local image cache directory
     */
    public function getImageCacheDir() {
        return \trailingslashit($this->getPluginCacheDir() . 'images/');
    }

    /**
     * Getting the local image cache URI
     *
     * @return string Local image cache URI
     */
    public function getImageCacheUri() {
        return \trailingslashit($this->getPluginCacheUri() . 'images/');
    }

    /**
     * creating our needed cache directories under:
     *      /wp-content/cache/plugin/«plugin-name»/
     *
     * @param string $directory The Directory to create
     */
    public function createCacheDirectory($directory = '') {
        $wpFileSystem = new \WP_Filesystem_Direct(null);
        $dirToCreate = \trailingslashit($this->getPluginCacheDir() . $directory);

        \wp_mkdir_p($dirToCreate);

        if(!$wpFileSystem->is_file($dirToCreate . '/index.php')) {
            $wpFileSystem->put_contents(
                $dirToCreate . '/index.php', '', 0644
            );
        }
    }

    /**
     * Chek if a remote image has been cached locally
     *
     * @param string $cacheType The subdirectory in the image cache filesystem
     * @param string $imageName The image file name
     * @return boolean true or false
     */
    public function checkCachedImage($cacheType = null, $imageName = null) {
        $returnValue = false;
        $cacheDir = \trailingslashit($this->getImageCacheDir() . $cacheType);

        if(\file_exists($cacheDir . $imageName)) {
            $returnValue = true;

            if(((\time() - \filemtime($cacheDir . $imageName)) > $this->pluginSettings['image-cache-time'] * 3600) || (\filesize($cacheDir . $imageName) === 0)) {
                \unlink($cacheDir . $imageName);

                $returnValue = false;
            }
        }

        return $returnValue;
    }

    /**
     * Cachng a remote image locally
     *
     * @param string $cacheType The subdirectory in the image cache filesystem
     * @param string $remoteImageUrl The URL for the remote image
     */
    public function cacheRemoteImageFile($cacheType = '', $remoteImageUrl = null) {
        $returnValue = false;
        $cacheDir = \trailingslashit($this->getImageCacheDir() . $cacheType);
        $explodedImageUrl = \explode('/', $remoteImageUrl);
        $imageFilename = \end($explodedImageUrl);
        $explodedImageFilename = \explode('.', $imageFilename);
        $extension = \end($explodedImageFilename);

        // make sure its an image
        if($extension === 'gif' || $extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
            // get the remote image
            $imageToFetch = $this->remoteHelper->getRemoteData($remoteImageUrl);

            $wpFileSystem = new \WP_Filesystem_Direct(null);

            if($wpFileSystem->put_contents($cacheDir . $imageFilename, $imageToFetch, 0755)) {
                $returnValue = $this->imageHelper->compressImage($cacheDir . $imageFilename);
            }
        }

        return $returnValue;
    }
}
