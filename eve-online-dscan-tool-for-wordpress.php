<?php
/**
 * Plugin Name: EVE Online D-Scan Tool for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-dscan-tool-for-wordpress
 * Git URI: https://github.com/ppfeufer/eve-online-dscan-tool-for-wordpress
 * Description: A D-Scan Tool for WordPress. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 1.0
 * Author: Rounon Dax
 * Author URI: http://yulaifederation.net
 * Text Domain: eve-online-dscan-tool-for-wordpress
 * Domain Path: /l10n
 */

// http://wordpress.stackexchange.com/questions/156173/frontend-form-for-custom-post-type
// https://pastebin.com/z5xwe4PA

namespace WordPress\Plugin\EveOnlineDscanTool;

class EveOnlineDscanTool {
	private $textDomain = null;
	private $localizationDirectory = null;
	private $pluginDir = null;
	private $pluginUri = null;

	public function __construct($init = false) {
		$this->textDomain = 'eve-online-dscan-tool-for-wordpress';
		$this->pluginDir =  \trailingslashit(\plugin_dir_path(__FILE__));
		$this->pluginUri = \trailingslashit(\plugins_url('/', __FILE__));
		$this->localizationDirectory = $this->pluginDir . 'l10n/';

		if($init === true) {
			$this->init();
		} // END if($init === true)
	} // END public function __construct($init = false)

	public function init() {
		$this->loadLibs();
		$this->checkDatabaseUpdate();

//		\add_action('wp_enqueue_scripts', array($this, 'enqueueJavaScript'));
		\add_action('wp_enqueue_scripts', array($this, 'enqueueStylesheet'));

		new Libs\PostType;

		/**
		 * start backend libs
		 */
		if(\is_admin()) {
			new Admin\PluginSettings;
		} // END if(\is_admin())
	} // END public function init()

	/**
	 * Loading all libs
	 */
	public function loadLibs() {
		foreach(\glob($this->pluginDir . 'helper/*.php') as $lib) {
			include_once($lib);
		} // END foreach(\glob($this->getPluginDir() . 'libs/*.php') as $lib)

		foreach(\glob($this->pluginDir . 'admin/*.php') as $lib) {
			include_once($lib);
		} // END foreach(\glob($this->getPluginDir() . 'admin/*.php') as $lib)

		foreach(\glob($this->pluginDir . 'libs/*.php') as $lib) {
			include_once($lib);
		} // END foreach(\glob($this->getPluginDir() . 'libs/*.php') as $lib)
	} // END public function loadLibs()

	private function checkDatabaseUpdate() {
		$currentPluginDatabaseVersion = Helper\PluginHelper::getCurrentPluginDatabaseVersion();
		$pluginDatabaseVersion = Helper\PluginHelper::getPluginDatabaseVersion();

		if($pluginDatabaseVersion !== $currentPluginDatabaseVersion) {
			Helper\PluginHelper::updateDatabase();
		} // END if($pluginDatabaseVersion !== $currentPluginDatabaseVersion)
	} // END private function checkDatabaseUpdate()

	public function enqueueStylesheet() {
		\wp_enqueue_style('font-awesome', $this->pluginUri . 'font-awesome/css/font-awesome.min.css');
	} // END public function enqueueStylesheet()
} // END class EveOnlineDscanTool

new EveOnlineDscanTool(true);
