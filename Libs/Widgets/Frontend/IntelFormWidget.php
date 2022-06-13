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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Widgets\Frontend;

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper;
use \WP_Widget;

\defined('ABSPATH') or die();

class IntelFormWidget extends WP_Widget {
    /**
     * Root ID for all widgets of this type.
     *
     * @since 2.8.0
     * @access public
     * @var mixed|string
     */
    public $id_base;

    /**
     * Name for this widget type.
     *
     * @since 2.8.0
     * @access public
     * @var string
     */
    public $name;

    /**
     * Unique ID number of the current instance.
     *
     * @since 2.8.0
     * @var bool|int
     */
    public $number = false;

    /**
     * Constructor
     */
    public function __construct() {
        $widgetOptions = [
            'classname' => 'eve-online-intel-tool-sidebar-widget',
            'description' => \__('Displaying the EVE intel form in your sidebar.', 'eve-online-intel-tool')
        ];

        $controlOptions = [];

        parent::__construct('eve_online_intel_tool_sidebar_widget', \__('EVE Online Intel Form Widget', 'eve-online-intel-tool'), $widgetOptions, $controlOptions);
    }

    /**
     * Widget Output
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance): void {
        echo $args['before_widget'];

        echo $args['before_title'];
        echo \__('EVE Quick Intel', 'eve-online-intel-tool');
        echo $args['after_title'];

        TemplateHelper::getInstance()->getTemplate('partials/intel-form', [
            'textareaRows' => 7
        ]);

        echo $args['after_widget'];
    }
}
