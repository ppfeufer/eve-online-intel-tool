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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Admin;

\defined('ABSPATH') or die();

/**
 * Registering the plugin settings
 */
class PluginSettings {
	/**
	 * Settings Filter
	 *
	 * @var string
	 */
	private $settingsFilter = null;

	/**
	 * Plugin Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper
	 */
	private $pluginHelper = null;

	/**
	 * Default Options
	 *
	 * @var array
	 */
	private $defaultOptions = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->pluginHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance();
		$this->settingsFilter = 'register_eve_online_intel_tool_settings';
		$this->defaultOptions = $this->pluginHelper->getPluginDefaultSettings();

		$this->fireSettingsApi();
	} // public function __construct()

	/**
	 * Fire the Settings API
	 */
	public function fireSettingsApi() {
		$settingsApi = new SettingsApi($this->settingsFilter, $this->defaultOptions);
		$settingsApi->init();

		\add_filter($this->settingsFilter, [$this, 'getSettings']);
	} // function fireSettingsApi()

	/**
	 * Getting the Settings for the Plugin Options Page
	 *
	 * @return array The Settings for the Options Page
	 */
	public function getSettings() {
		$pluginOptionsPage['eve-online-intel-tool'] = [
			'type' => 'plugin',
			'menu_title' => \__('EVE Online Intel Tool', 'eve-online-intel-tool'),
			'page_title' => \__('EVE Online Intel Tool', 'eve-online-intel-tool'),
			'option_name' => $this->pluginHelper->getOptionFieldName(), // Your settings name. With this name your settings are saved in the database.
			'tabs' => [
				/**
				 * general settings tab
				 */
				'general-settings' => $this->getGeneralSettings(),
			]
		];

		return $pluginOptionsPage;
	} // function renderSettingsPage()

	/**
	 * Getting the Killboard Databse Settings
	 *
	 * @return array The Killboard Database Setting
	 */
	private function getGeneralSettings() {
		$settings = [
			'tab_title' => \__('General Settings', 'eve-online-intel-tool'),
			'tab_description' => \__('General Settings for EVE Online Intel Tool', 'eve-online-intel-tool'),
			'fields' => $this->getGeneralSettingsFields()
		];

		return $settings;
	} // private function getGeneralSettings()

	/**
	 * Get the settings fields for the Killboard settings
	 * @return array Settings fields for the Killboard settings
	 */
	private function getGeneralSettingsFields() {
		$settingsFields = [
			'image-cache' => [
				'title' => \__('Image Cache', 'eve-online-intel-tool'),
				'description' => \__('Select this if you want to use a local image cache for all images used by this plugin (pilot avatars, corp- and alliance logos, ship images and so on). Images will be downloaded on demand from CCP\'s image server and than stored locally.', 'eve-online-intel-tool'),
				'type' => 'checkbox',
				'choices' => [
					'yes' => \__('Use a serverside cache for images fetched from CCP\'s image server.', 'eve-online-intel-tool')
				]
			],
			'image-lazy-load' => [
				'title' => \__('Lazy-Load images', 'eve-online-intel-tool'),
				'description' => \__('Start loading EVE related images (Pilot-Avatars, Corp-Logos and Alliance-Logos) after the result page has been loaded. This might speed things a bit up, especially when using the image cache and new images have to be downloaded and cached first. <small><strong>(Only works when using the image cache.)</strong></small><br><strong>!!! DO NOT USE IT WHEN YOU HAVE A STATIC PAGE CACHE !!!</strong>', 'eve-online-intel-tool'),
				'type' => 'checkbox',
				'choices' => [
					'yes' => \__('Use a lazy loading mechanism for EVE related images.', 'eve-online-intel-tool')
				]
			],
			'image-cache-time' => [
				'title' => \__('Image Cache Time', 'eve-online-intel-tool'),
				'description' => \__('Set the time in days a cached image is valid.', 'eve-online-intel-tool'),
				'type' => 'select',
				'choices' => [
					'120' => \__('5 days', 'eve-online-intel-tool'),
					'240' => \__('10 days', 'eve-online-intel-tool'),
					'360' => \__('15 days', 'eve-online-intel-tool'),
					'480' => \__('20 days', 'eve-online-intel-tool'),
				]
			],
//			'pilot-data-cache-time' => [
//				'title' => \__('Pilot Data Cache Time', 'eve-online-intel-tool'),
//				'description' => \__('Set the time in days the pilots API information is cached. Since a pilot can change corporation, a smaller cache time is appropriate.', 'eve-online-intel-tool'),
//				'type' => 'select',
//				'choices' => [
//					'120' => \__('5 days', 'eve-online-intel-tool'),
//					'240' => \__('10 days', 'eve-online-intel-tool'),
//					'360' => \__('15 days', 'eve-online-intel-tool'),
//					'480' => \__('20 days', 'eve-online-intel-tool'),
//				]
//			],
//			'corp-data-cache-time' => [
//				'title' => \__('Corp Data Cache Time', 'eve-online-intel-tool'),
//				'description' => \__('Set the time in days the corporations API information is cached. For this, a medium cache time is appropriate.', 'eve-online-intel-tool'),
//				'type' => 'select',
//				'choices' => [
//					'120' => \__('5 days', 'eve-online-intel-tool'),
//					'240' => \__('10 days', 'eve-online-intel-tool'),
//					'360' => \__('15 days', 'eve-online-intel-tool'),
//					'480' => \__('20 days', 'eve-online-intel-tool'),
//					'600' => \__('25 days', 'eve-online-intel-tool'),
//					'1200' => \__('50 days', 'eve-online-intel-tool'),
//				]
//			],
//			'alliance-data-cache-time' => [
//				'title' => \__('Alliance Data Cache Time', 'eve-online-intel-tool'),
//				'description' => \__('Set the time in days the corporations API information is cached. Since this information doesn\'t change to often, a large cache time is appropriate.', 'eve-online-intel-tool'),
//				'type' => 'select',
//				'choices' => [
//					'120' => \__('5 days', 'eve-online-intel-tool'),
//					'240' => \__('10 days', 'eve-online-intel-tool'),
//					'360' => \__('15 days', 'eve-online-intel-tool'),
//					'480' => \__('20 days', 'eve-online-intel-tool'),
//					'600' => \__('25 days', 'eve-online-intel-tool'),
//					'1200' => \__('50 days', 'eve-online-intel-tool'),
//					'2400' => \__('100 days', 'eve-online-intel-tool'),
//					'4800' => \__('200 days', 'eve-online-intel-tool'),
//					'5110' => \__('1 year', 'eve-online-intel-tool'),
//				]
//			],
		];

		return $settingsFields;
	} // private function getGeneralSettingsFields()
} // class PluginSettings
