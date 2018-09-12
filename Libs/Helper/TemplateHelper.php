<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class TemplateHelper {
    /**
     * Locate template.
     *
     * Locate the called template.
     * Search Order:
     * 1. /themes/theme/templates/$template_name
     * 2. /themes/theme/$template_name
     * 3. /plugins/eve-online-intel-tool/templates/$template_name.
     *
     * @since 1.0.0
     *
     * @param 	string 	$template_name			Template to load.
     * @param 	string 	$template_path			Path to templates.
     * @param 	string	$default_path			Default path to template files.
     * @return 	string 							Path to the template file.
     */
    public static function locateTemplate($template_name, $template_path = '', $default_path = '') {
        // Set variable to search in templates folder of theme.
        if(!$template_path) {
            $template_path = 'templates/';
        }

        // fail safe
        if(\substr($template_name, -4) !== '.php') {
            $template_name .= '.php';
        }

        // Set default plugin templates path.
        if(!$default_path) {
            $default_path = PluginHelper::getInstance()->getPluginPath('templates/'); // Path to the template folder
        }

        // Search template file in theme folder.
        $template = \locate_template([
            $template_path . $template_name,
            $template_name
        ]);

        // Get plugins template file.
        if(!$template) {
            $template = $default_path . $template_name;
        }

        return \apply_filters('eve-online-intel-tool_locate_template', $template, $template_name, $template_path, $default_path);
    }

    /**
     * Get template.
     *
     * Search for the template and include the file.
     *
     * @since 1.0.0
     *
     * @see locateTemplate()
     *
     * @param string 	$template_name			Template to load.
     * @param array 	$args					Args passed for the template file.
     * @param string 	$tempate_path			Path to templates.
     * @param string	$default_path			Default path to template files.
     */
    public static function getTemplate($template_name, $args = [], $tempate_path = '', $default_path = '') {
        if(\is_array($args) && isset($args)) {
            \extract($args);
        }

        // fail safe
        if(\substr($template_name, -4) !== '.php') {
            $template_name .= '.php';
        }

        $template_file = self::locateTemplate($template_name, $tempate_path, $default_path);

        if(!\file_exists($template_file)) {
            \_doing_it_wrong(__FUNCTION__, \sprintf('<code>%s</code> does not exist.', $template_file), '1.0.0');

            return;
        }

        include $template_file;
    }
}
