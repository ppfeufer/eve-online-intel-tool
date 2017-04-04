<?php

namespace WordPress\Plugin\EveOnlineDscanTool\Helper;

class PluginHelper {
	public static $optionName = 'eve-online-dscan-tool-options';
	public static $dbVersionFieldName = 'eve-online-dscan-tool-database-version';
	public static $databaseVersion = '20170404';

	/**
	 * Getting thew options field name
	 *
	 * @return string
	 */
	public static function getOptionFieldName() {
		return self::$optionName;
	} // END public function getOptionFieldName()

	/**
	 * Getting the Database Version field name
	 *
	 * @return string
	 */
	public static function getDatabaseVersionFieldName() {
		return self::$dbVersionFieldName;
	} // END public function getDatabaseVersionFieldName()

	/**
	 * Getting the Database Version from plugin
	 *
	 * @return string
	 */
	public static function getCurrentPluginDatabaseVersion() {
		return self::$databaseVersion;
	} // END private function getCurrentPluginDatabaseVersion()

	/**
	 * Returning the default settings for this plugin
	 *
	 * @return array
	 */
	public static function getPluginDefaultSettings() {
		$defaultSettings = array(
			'edk-killboard-host' => '',
			'edk-killboard-user' => '',
			'edk-killboard-name' => '',
			'edk-killboard-password' => ''
		);

		return $defaultSettings;
	} // END public function getDefaultSettings()

	/**
	 * Getting the Database Version from options
	 *
	 * @return string
	 */
	public static function getPluginDatabaseVersion() {
		return \get_option(self::getDatabaseVersionFieldName());
	} // END private function getDatabaseVersion()

	public static function updateDatabase() {
		$defaultSettings = self::getPluginDefaultSettings();
		$pluginSettings = self::getPluginSettings(false);

		if(\is_array($pluginSettings)) {
			$newOptions = \array_merge($defaultSettings, $pluginSettings);
		} else {
			$newOptions = $defaultSettings;
		} // END if(\is_array($pluginSettings))

		// Update the options
		\update_option(self::getOptionFieldName(), $newOptions);

		// Update the DB Version
		\update_option(self::getDatabaseVersionFieldName(), self::getCurrentPluginDatabaseVersion());
	} // END private function updateDatabase()

	/**
	 * Getting the Plugin's settings
	 *
	 * @param boolean $merged Merge with default settings (true/false)
	 * @return array
	 */
	public static function getPluginSettings($merged = true) {
		if($merged === true) {
			$pluginSettings = \get_option(self::getOptionFieldName(), self::getPluginDefaultSettings);
		} else {
			$pluginSettings = \get_option(self::getOptionFieldName());
		} // END if($merged === true)

		return $pluginSettings;
	} // END public function getPluginSettings($merged = true)

	/**
	 * checking for other plugins we might be able to use
	 */
	public static function checkPluginDependencies($plugin) {
		$returnValue = false;

		if(\class_exists($plugin)) {
			$returnValue = true;
		} // END if(\class_exists('EVEShipInfo'))

		return $returnValue;
	} // END public function checkPluginDependencies($plugin)

	public static function getPluginPath() {
		return plugin_dir_path(str_replace('helper', '', __FILE__));
	}

	public static function getPluginUri() {
		return plugin_dir_url(str_replace('helper', '', __FILE__));
	}
}
