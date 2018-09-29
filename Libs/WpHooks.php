<?php

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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs;

\defined('ABSPATH') or die();

class WpHooks {
    /**
     * Path to the plugin main file
     *
     * @var string
     */
    private $pluginFile = null;

    /**
     * New database version
     *
     * @var string
     */
    private $newDatabaseVersion = null;

    /**
     * Constructor
     *
     * @param array $parameter array with parameters
     */
    public function __construct(array $parameter) {
        $this->pluginFile = Helper\PluginHelper::getInstance()->getPluginPath('eve-online-intel-tool.php');
        $this->newDatabaseVersion = (isset($parameter['newDatabaseVersion'])) ? $parameter['newDatabaseVersion'] : null;

        $this->init();
    }

    /**
     * Initialize all the needed hooks, filter, actions and so on
     */
    public function init() {
        $this->initHooks();
        $this->initActions();
        $this->initFilter();
    }

    /**
     * Initialize our hooks
     */
    public function initHooks() {
        \register_activation_hook($this->pluginFile, [$this, 'checkDatabaseForUpdates']);
        \register_activation_hook($this->pluginFile, [$this, 'flushRewriteRulesOnActivation']);

        \register_deactivation_hook($this->pluginFile, [$this, 'flushRewriteRulesOnDeactivation']);
    }

    /**
     * Add our actions to WordPress
     */
    public function initActions() {
        \add_action('wp_head', [$this, 'noindexForIntelPages']);

        /**
         * in case of plugin update this need to be fired
         * since the activation doesn't fire on update
         * thx wordpress for removing update hooks ...
         */
        \add_action('plugins_loaded', [$this, 'checkDatabaseForUpdates']);
    }

    /**
     * Initializing our filter
     */
    public function initFilter() {
        \add_filter('plugin_row_meta', [$this, 'addPluginRowMeta'], 10, 2);
    }

    /**
     * Ading some links to the plugin row meta data
     *
     * @param array $links
     * @param string $file
     * @return array
     */
    public function addPluginRowMeta($links, $file) {
        if(\strpos($file, 'eve-online-intel-tool.php') !== false) {
            $new_links = [
                'issue_tracker' => '<a href="https://github.com/ppfeufer/eve-online-intel-tool/issues" target="_blank">GitHub Issue Tracker</a>',
                'support_discord' => '<a href="https://discord.gg/YymuCZa" target="_blank">Support Discord</a>'
            ];

            $links = \array_merge($links, $new_links);
        }

        return $links;
    }

    /**
     * Adding noindex and nofollow meta
     */
    public function noindexForIntelPages() {
        if(PostType::isPostTypePage() === true) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        }
    }

    /**
     * Hook: checkDatabaseForUpdates
     * Fired on: register_activation_hook
     */
    public function checkDatabaseForUpdates() {
        Helper\DatabaseHelper::getInstance()->checkDatabase($this->newDatabaseVersion);
    }

    /**
     * Hook: flushRewriteRulesOnActivation
     * Fired on: register_activation_hook
     */
    public function flushRewriteRulesOnActivation() {
        PostType::registerCustomPostType();

        \flush_rewrite_rules();
    }

    /**
     * Hook: flushRewriteRulesOnDeactivation
     * Fired on: register_deactivation_hook
     */
    public function flushRewriteRulesOnDeactivation() {
        \flush_rewrite_rules();
    }
}
