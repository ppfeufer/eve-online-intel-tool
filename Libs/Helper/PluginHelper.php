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

class PluginHelper extends AbstractSingleton {
    /**
     * Getting the Plugin Path
     *
     * @param string $file
     * @return string
     */
    public function getPluginPath(string $file = ''): string {
        return \WP_PLUGIN_DIR . '/' . $this->getPluginDirName() . '/' . $file;
    }

    /**
     * Getting the Plugin URI
     *
     * @param string $file
     * @return string
     */
    public function getPluginUri(string $file = ''): string {
        return \WP_PLUGIN_URL . '/' . $this->getPluginDirName() . '/' . $file;
    }

    /**
     * Get the plugins directory base name
     *
     * @return string
     */
    public function getPluginDirName(): string {
        return dirname(\plugin_basename(__FILE__), 3);
    }
}
