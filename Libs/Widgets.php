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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs;

\defined('ABSPATH') or die();

class Widgets {
    /**
     * Constructor
     */
    public function __construct() {
        ;
    }

    /**
     * Initialize frontend widgets
     */
    public function init() {
        \add_action('widgets_init', \create_function('', 'return register_widget("WordPress\Plugins\EveOnlineIntelTool\Libs\Widgets\Frontend\IntelFormWidget");'));
    }
}
