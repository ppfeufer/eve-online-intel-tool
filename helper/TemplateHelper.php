<?php

namespace WordPress\Plugin\EveOnlineDscanTool\Helper;

use WordPress\Plugin\EveOnlineDscanTool;

class TemplateHelper {
	/**
	 * Locate template.
	 *
	 * Locate the called template.
	 * Search Order:
	 * 1. /themes/theme/templates/$template_name
	 * 2. /themes/theme/$template_name
	 * 3. /plugins/eve-online-fitting-manager/templates/$template_name.
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
		} // END if(!$template_path)

		// fail safe
		if(\substr($template_name, -4) !== '.php') {
			$template_name .= '.php';
		} // END if(\substr($template_name, -4) !== '.php')

		// Set default plugin templates path.
		if(!$default_path) {
			$default_path = EveOnlineDscanTool\Helper\PluginHelper::getPluginPath() . 'templates/'; // Path to the template folder
		} // END if(!$default_path)

		// Search template file in theme folder.
		$template = \locate_template(array(
			$template_path . $template_name,
			$template_name
		));

		// Get plugins template file.
		if(!$template) {
			$template = $default_path . $template_name;
		} // END if(!$template)

		return \apply_filters('eve-online-fitting-manager_locate_template', $template, $template_name, $template_path, $default_path);
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
	public static function getTemplate($template_name, $args = array(), $tempate_path = '', $default_path = '') {
		if(\is_array($args) && isset($args)) {
			\extract($args);
		} // END if(\is_array($args) && isset($args))

		// fail safe
		if(\substr($template_name, -4) !== '.php') {
			$template_name .= '.php';
		} // END if(\substr($template_name, -4) !== '.php')

		$template_file = self::locateTemplate($template_name, $tempate_path, $default_path);

		if(!\file_exists($template_file)) {
			\_doing_it_wrong(__FUNCTION__, \sprintf('<code>%s</code> does not exist.', $template_file), '1.0.0');

			return;
		} // END if(!\file_exists($template_file))

		include $template_file;
	} // END function getTemplate($template_name, $args = array(), $tempate_path = '', $default_path = '')
}
