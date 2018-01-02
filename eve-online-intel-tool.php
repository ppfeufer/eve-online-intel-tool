<?php
/**
 * Plugin Name: EVE Online Intel Tool for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * GitHub Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Description: An EVE Online Intel Tool for WordPress. Parsing D-Scans, Local and Fleet Compositions. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 0.6.0
 * Author: Rounon Dax
 * Author URI: https://yulaifederation.net
 * Text Domain: eve-online-intel-tool
 * Domain Path: /l10n
 */

namespace WordPress\Plugin\EveOnlineIntelTool;

\defined('ABSPATH') or die();

const WP_GITHUB_FORCE_UPDATE = true;

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(\trailingslashit(\dirname(__FILE__)) . 'inc/autoloader.php');
require_once(\trailingslashit(\dirname(__FILE__)) . 'Libs/GuzzleHttp/functions_include.php');
require_once(\trailingslashit(\dirname(__FILE__)) . 'Libs/GuzzleHttp/Psr7/functions_include.php');
require_once(\trailingslashit(\dirname(__FILE__)) . 'Libs/GuzzleHttp/Promise/functions_include.php');

class EveOnlineIntelTool {
	/**
	 * Textdomain
	 *
	 * @var string
	 */
	private $textDomain = null;

	/**
	 * Localization Directory
	 *
	 * @var string
	 */
	private $localizationDirectory = null;

	/**
	 * Database version
	 *
	 * @var string
	 */
	private $databaseVersion = null;

	/**
	 * Plugin constructor
	 */
	public function __construct() {
		/**
		 * Initializing Variables
		 */
		$this->textDomain = 'eve-online-intel-tool';
		$this->localizationDirectory = \basename(\dirname(__FILE__)) . '/l10n/';

		$this->databaseVersion = '20171104';
	} // END public function __construct()

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$this->loadTextDomain();

		new Libs\PostType;
		new Libs\Ajax\FormNonce;
		new Libs\Ajax\ImageLazyLoad;

		new Libs\WpHooks([
			'newDatabaseVersion' => $this->databaseVersion
		]);

		$jsLoader = new Libs\ResourceLoader\JavascriptLoader;
		$jsLoader->init();

		$cssLoader = new Libs\ResourceLoader\CssLoader;
		$cssLoader->init();

		if(\is_admin()) {
			new Libs\Admin\PluginSettings;
			new Libs\Widgets\Dashboard\CacheStatisticsWidget;

			$this->initGitHubUpdater();
		} // if(\is_admin())
	} // public function init()

	/**
	 * Initializing the GitHub Updater
	 */
	private function initGitHubUpdater() {
		new Libs\TemplateLoader;

		/**
		 * Check Github for updates
		 */
		$githubConfig = [
			'slug' => \plugin_basename(__FILE__),
//			'proper_folder_name' => \dirname(\plugin_basename(__FILE__)),
			'proper_folder_name' => Libs\Helper\PluginHelper::getInstance()->getPluginDirName(),
			'api_url' => 'https://api.github.com/repos/ppfeufer/eve-online-intel-tool',
			'raw_url' => 'https://raw.github.com/ppfeufer/eve-online-intel-tool/master',
			'github_url' => 'https://github.com/ppfeufer/eve-online-intel-tool',
			'zip_url' => 'https://github.com/ppfeufer/eve-online-intel-tool/archive/master.zip',
			'sslverify' => true,
			'requires' => '4.7',
			'tested' => '4.9',
			'readme' => 'README.md',
			'access_token' => '',
		];

		new Libs\GithubUpdater($githubConfig);
	} // private function initGitHubUpdater()

	/**
	 * Setting up our text domain for translations
	 */
	public function loadTextDomain() {
		if(\function_exists('\load_plugin_textdomain')) {
			\load_plugin_textdomain($this->textDomain, false, $this->localizationDirectory);
		} // if(function_exists('\load_plugin_textdomain'))
	} // public function addTextDomain()
} // class EveOnlineIntelTool

/**
 * Start the show ....
 */
function initializePlugin() {
	$eveIntelTool = new EveOnlineIntelTool;

	/**
	 * Initialize the plugin
	 *
	 * @todo https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
	 */
	$eveIntelTool->init();
} // function initializePlugin()

// Start the show
initializePlugin();
