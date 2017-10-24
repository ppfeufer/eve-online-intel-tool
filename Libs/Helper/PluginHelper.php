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

class PluginHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * Option field name for plugin options
	 *
	 * @var string
	 */
	public $optionFieldName = 'eve-online-intel-tool-options';

	/**
	 * Getting the Plugin Path
	 *
	 * @param string $file
	 * @return string
	 */
	public function getPluginPath($file = '') {
		return \WP_PLUGIN_DIR . '/' . $this->getPluginDirName() . '/' . $file;
	} // public function getPluginPath($file = '')

	/**
	 * Getting the Plugin URI
	 *
	 * @param string $file
	 * @return string
	 */
	public function getPluginUri($file = '') {
		return \WP_PLUGIN_URL . '/' . $this->getPluginDirName() . '/' . $file;
	} // public function getPluginUri()

	/**
	 * Get the plugins directory base name
	 *
	 * @return string
	 */
	public function getPluginDirName() {
		return \dirname(\dirname(\dirname(\plugin_basename(__FILE__))));
	} // END public function getPluginDirName()

	/**
	 * Returning the plugins default settings
	 *
	 * @return array
	 */
	public function getPluginDefaultSettings() {
		return [
			'image-cache' => '',
			'image-lazy-load' => '',
			'image-cache-time' => '120'
//			'pilot-data-cache-time' => '120',
//			'corp-data-cache-time' => '360',
//			'alliance-data-cache-time' => '2400'
		];
	} // public function getPluginDefaultSettings()

	/**
	 * Getting the plugin settings
	 *
	 * @return array
	 */
	public function getPluginSettings() {
		return \get_option($this->getOptionFieldName(), $this->getPluginDefaultSettings());
	} // public function getPluginSettings()

	/**
	 * Returning the options field name
	 *
	 * @return string
	 */
	public function getOptionFieldName() {
		return $this->optionFieldName;
	} // public function getOptionFieldName()
} // class PluginHelper
