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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface;
use WordPress\Plugins\EveOnlineIntelTool\Libs\PostType;

/**
 * CSS Loader
 */
class CssLoader implements AssetsInterface {
    /**
     * Plugin Helper
     *
     * @var PluginHelper
     */
    private PluginHelper $pluginHelper;

    /**
     * Constructor
     */
    public function __construct() {
        $this->pluginHelper = PluginHelper::getInstance();
    }

    /**
     * Initialize the loader
     */
    public function init(): void {
        add_action(hook_name: 'wp_enqueue_scripts', callback: [$this, 'enqueue'], priority: 99);
    }

    /**
     * Load the styles
     */
    public function enqueue(): void {
        /**
         * Only in Frontend
         */
        /**
         * load only when needed
         */
        if (!is_admin() && PostType::getInstance()->isPostTypePage() === true) {
            wp_enqueue_style(
                handle: 'font-awesome',
                src: $this->pluginHelper->getPluginUri(file: 'font-awesome/css/font-awesome.min.css')
            );
            wp_enqueue_style(
                handle: 'bootstrap',
                src: $this->pluginHelper->getPluginUri(file: 'bootstrap/css/bootstrap.min.css')
            );
            wp_enqueue_style(
                handle: 'data-tables-bootstrap',
                src: $this->pluginHelper->getPluginUri(file: 'css/data-tables/dataTables.bootstrap.min.css')
            );
            wp_enqueue_style(
                handle: 'eve-online-intel-tool',
                src: $this->pluginHelper->getPluginUri(file: 'css/eve-online-intel-tool.min.css')
            );
        }
    }
}
