<?php

namespace WordPress\Plugin\EveOnlineDscanTool\Admin;

use WordPress\Plugin\EveOnlineDscanTool;

\defined('ABSPATH') or die();

class PluginSettings {
	public $settingsFilter = null;
	public $defaultOptions = null;

	public function __construct() {
		$this->settingsFilter = 'register_dscan-tool-settings';
		$this->defaultOptions = EveOnlineDscanTool\Helper\PluginHelper::getPluginDefaultSettings();

		$this->fireSettingsApi();
	}

	public function fireSettingsApi() {
		$settingsApi = new SettingsApi($this->settingsFilter, $this->defaultOptions);
		$settingsApi->init();

		\add_filter($this->settingsFilter, array($this, 'getSettings'));
	} // END function fireSettingsApi()

	function getSettings() {
		$themeOptionsPage['eve-online-dscan-tool'] = array(
			'type' => 'plugin',
			'menu_title' => \__('D-Scan Tool', 'my-text-domain'),
			'page_title' => \__('D-Scan Tool Settings', 'my-text-domain'),
			'option_name' => EveOnlineDscanTool\Helper\PluginHelper::getOptionFieldName(), // Your settings name. With this name your settings are saved in the database.
			'tabs' => array(
				/**
				 * general settings tab
				 */
				'killboard-settings' => $this->getKillboardSettings(),
			)
		);

		return $themeOptionsPage;
	} // END function renderSettingsPage()

	private function getKillboardSettings() {
		$settings = array(
			'tab_title' => \__('Killboard Settings', 'eve-online-dscan-tool-for-wordpress'),
			'tab_description' => \__('You need to have a connection to a EDK killboard database in order to use this plugin. The database is needed to gather all the ship and item information.', 'eve-online-dscan-tool-for-wordpress'),
			'fields' => $this->getKillboardSettingsFields()
		);

		return $settings;
	} // END private function getKillboardSettings()

	private function getKillboardSettingsFields() {
		$infotext = sprintf(
			\__('If you don\'t have a local EDK killboard installation you can use, it is suggested to install and activate the %1$s plugin, so we can use this plugins database.', 'eve-online-dscan-tool-for-wordpress'),
			'<a href="http://www.aeonoftime.com/EVE_Online_Tools/EVE-ShipInfo-WordPress-Plugin/download.php" target="_blank">' . \__('EVE ShipInfo', 'eve-online-dscan-tool-for-wordpress') . '</a>'
		);

		if(EveOnlineDscanTool\Helper\PluginHelper::checkPluginDependencies('EVEShipInfo') === true) {
			$infotext = \__('Since you already have the EVE ShipInfo Plugin installed and activated, there is no need for any other settings, we can use that plugins database straight away.', 'eve-online-dscan-tool-for-wordpress');
		} // END if($this->plugin->pluginEveShipInfo === true)

		$settingsFields = array(
			'' => array(
				'type' => 'info',
				'infotext' => $infotext
			),
			'edk-killboard-host' => array(
				'type' => 'text',
				'title' => \__('DB Host', 'eve-online-dscan-tool-for-wordpress'),
				'default' => 'localhost'
			),
			'edk-killboard-name' => array(
				'type' => 'text',
				'title' => \__('DB Name', 'eve-online-dscan-tool-for-wordpress'),
			),
			'edk-killboard-user' => array(
				'type' => 'text',
				'title' => \__('DB User', 'eve-online-dscan-tool-for-wordpress'),
			),
			'edk-killboard-password' => array(
				'type' => 'password',
				'title' => \__('DB Password', 'eve-online-dscan-tool-for-wordpress'),
			)
		);

		return $settingsFields;
	} // END private function getKillboardSettingsFields()
}
