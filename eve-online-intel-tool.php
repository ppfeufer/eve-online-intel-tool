<?php
/**
 * Plugin Name: EVE Online Intel Tool for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Git URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Description: An EVE Online Intel Tool for WordPress. Parsing D-Scans, Local and Fleet Compositions. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 0.1.2
 * Author: Rounon Dax
 * Author URI: http://yulaifederation.net
 * Text Domain: eve-online-intel-tool
 * Domain Path: /l10n
 */

namespace WordPress\Plugin\EveOnlineIntelTool;
const WP_GITHUB_FORCE_UPDATE = true;

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(\trailingslashit(\dirname(__FILE__)) . 'inc/autoloader.php');

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
	 * Plugin Directory
	 *
	 * @var string
	 */
	private $pluginDir = null;

	/**
	 * PLugin URI
	 *
	 * @var string
	 */
	private $pluginUri = null;

	/**
	 * Plugin constructor
	 *
	 * @param boolean $init
	 */
	public function __construct() {
		/**
		 * Initializing Variables
		 */
		$this->textDomain = 'eve-online-intel-tool';
		$this->pluginDir = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginPath();
		$this->pluginUri = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri();
		$this->localizationDirectory = $this->pluginDir . '/l10n/';

		$this->loadTextDomain();
	} // END public function __construct()

	/**
	 * Initialize the plugin
	 */
	public function init() {
		$jsLoader = new Libs\ResourceLoader\JavascriptLoader;
		$jsLoader->init();

		$cssLoader = new Libs\ResourceLoader\CssLoader;
		$cssLoader->init();

		new Libs\PostType;

		if(\is_admin()) {
			new Libs\TemplateLoader;

			/**
			 * Check Github for updates
			 */
			$githubConfig = [
				'slug' => \plugin_basename(__FILE__),
				'proper_folder_name' => \dirname(\plugin_basename(__FILE__)),
				'api_url' => 'https://api.github.com/repos/ppfeufer/eve-online-intel-tool',
				'raw_url' => 'https://raw.github.com/ppfeufer/eve-online-intel-tool/master',
				'github_url' => 'https://github.com/ppfeufer/eve-online-intel-tool',
				'zip_url' => 'https://github.com/ppfeufer/eve-online-intel-tool/archive/master.zip',
				'sslverify' => true,
				'requires' => '4.7',
				'tested' => '4.9-alpha',
				'readme' => 'README.md',
				'access_token' => '',
			];

			new Libs\GithubUpdater($githubConfig);
		} // END if(\is_admin())
	} // END public function init()

	/**
	 * Setting up our text domain for translations
	 */
	public function loadTextDomain() {
		if(\function_exists('\load_plugin_textdomain')) {
			\load_plugin_textdomain($this->textDomain, false, $this->localizationDirectory);
		} // END if(function_exists('\load_plugin_textdomain'))
	} // END public function addTextDomain()
} // END class EveOnlineIntelTool

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
} // END function initializePlugin()

// Start the show
\add_action('plugins_loaded', 'WordPress\Plugin\EveOnlineIntelTool\initializePlugin');
