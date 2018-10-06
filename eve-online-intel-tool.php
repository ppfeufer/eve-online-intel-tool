<?php

/**
 * Plugin Name: EVE Online Intel Tool for WordPress
 * Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * GitHub Plugin URI: https://github.com/ppfeufer/eve-online-intel-tool
 * Description: An EVE Online Intel Tool for WordPress. Parsing D-Scans, Local and Fleet Compositions. (Best with a theme running with <a href="http://getbootstrap.com/">Bootstrap</a>)
 * Version: 1.3.0
 * Author: Rounon Dax
 * Author URI: https://yulaifederation.net
 * Text Domain: eve-online-intel-tool
 * Domain Path: /l10n
 */

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

namespace WordPress\Plugins\EveOnlineIntelTool;

use WordPress\Plugins\EveOnlineIntelTool\Libs\Ajax\FormNonce;
use WordPress\Plugins\EveOnlineIntelTool\Libs\GithubUpdater;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\UpdateHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\ResourceLoader\CssLoader;
use WordPress\Plugins\EveOnlineIntelTool\Libs\ResourceLoader\JavascriptLoader;
use WordPress\Plugins\EveOnlineIntelTool\Libs\TemplateLoader;
use WordPress\Plugins\EveOnlineIntelTool\Libs\WpHooks;

\defined('ABSPATH') or die();

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
     * Plugin constructor
     */
    public function __construct() {
        /**
         * Initializing Variables
         */
        $this->textDomain = 'eve-online-intel-tool';
        $this->localizationDirectory = \basename(\dirname(__FILE__)) . '/l10n/';
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        new WpHooks;

        $this->loadTextDomain();

        new FormNonce;

        $jsLoader = new JavascriptLoader;
        $jsLoader->init();

        $cssLoader = new CssLoader;
        $cssLoader->init();

        if(\is_admin()) {
            new TemplateLoader;

            $this->initGitHubUpdater();
        }
    }

    /**
     * Initializing the GitHub Updater
     */
    private function initGitHubUpdater() {
        /**
         * Check Github for updates
         */
        $githubConfig = [
            'slug' => \plugin_basename(__FILE__),
            'proper_folder_name' => PluginHelper::getInstance()->getPluginDirName(),
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

        new GithubUpdater($githubConfig);
    }

    /**
     * Setting up our text domain for translations
     */
    public function loadTextDomain() {
        if(\function_exists('\load_plugin_textdomain')) {
            \load_plugin_textdomain($this->textDomain, false, $this->localizationDirectory);
        }
    }
}

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
}

// Start the show
initializePlugin();
