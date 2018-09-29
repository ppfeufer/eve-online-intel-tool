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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\ResourceLoader;

\defined('ABSPATH') or die();

/**
 * CSS Loader
 */
class CssLoader implements \WordPress\Plugins\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface {
    /**
     * Plugin Helper
     *
     * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper
     */
    private $pluginHelper = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->pluginHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance();
    }

    /**
     * Initialize the loader
     */
    public function init() {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
    }

    /**
     * Load the styles
     */
    public function enqueue() {
        /**
         * Only in Frontend
         */
        if(!\is_admin()) {
            /**
             * load only when needed
             */
            if(\WordPress\Plugins\EveOnlineIntelTool\Libs\PostType::isPostTypePage() === true) {
                \wp_enqueue_style('font-awesome', $this->pluginHelper->getPluginUri('font-awesome/css/font-awesome.min.css'));
                \wp_enqueue_style('bootstrap', $this->pluginHelper->getPluginUri('bootstrap/css/bootstrap.min.css'));
                \wp_enqueue_style('data-tables-bootstrap', $this->pluginHelper->getPluginUri('css/data-tables/dataTables.bootstrap.min.css'));
                \wp_enqueue_style('eve-online-intel-tool', $this->pluginHelper->getPluginUri('css/eve-online-intel-tool.min.css'));
            }
        }
    }
}
