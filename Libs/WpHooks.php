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

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\UpdateHelper;

class WpHooks {
    /**
     * Path to the plugin main file
     *
     * @var string
     */
    private string $pluginFile;

    /**
     * Constructor
     */
    public function __construct() {
        $this->pluginFile = PluginHelper::getInstance()->getPluginPath(
            file: 'eve-online-intel-tool.php'
        );

        $this->init();
    }

    /**
     * Initialize all the needed hooks, filter, actions and so on
     */
    public function init(): void {
        $this->initHooks();
        $this->initActions();
        $this->initFilter();
    }

    /**
     * Initialize our hooks
     */
    public function initHooks(): void {
        register_activation_hook(
            file: $this->pluginFile,
            callback: [UpdateHelper::getInstance(), 'checkDatabaseForUpdates']
        );
        register_activation_hook(
            file: $this->pluginFile,
            callback: [UpdateHelper::getInstance(), 'checkEsiClientForUpdates']
        );
        register_activation_hook(
            file: $this->pluginFile,
            callback: [$this, 'registerPostTypeOnActivation']
        );

        register_deactivation_hook(
            file: $this->pluginFile,
            callback: [$this, 'unregisterPostTypeOnDeactivation']
        );
        register_deactivation_hook(
            file: $this->pluginFile,
            callback: [$this, 'removeDatabaseVersionOnDeactivation']
        );
    }

    /**
     * Add our actions to WordPress
     */
    public function initActions(): void {
        /**
         * Stuff that's added to the HTML head section
         */
        add_action(hook_name: 'wp_head', callback: [$this, 'noindexForIntelPages']);
        add_action(hook_name: 'wp_head', callback: [$this, 'setMetaDescription']);

        /**
         * in case of plugin update this need to be fired
         * since the activation doesn't fire on update
         * thx wordpress for removing update hooks ...
         */
        add_action(
            hook_name: 'plugins_loaded',
            callback: [UpdateHelper::getInstance(), 'checkDatabaseForUpdates']
        );
        add_action(
            hook_name: 'plugins_loaded',
            callback: [UpdateHelper::getInstance(), 'checkEsiClientForUpdates']
        );

        /**
         * Initializing widgets
         */
        add_action(
            hook_name: 'widgets_init',
            callback: [Widgets::getInstance(), 'registerWidgets']
        );

        add_action(
            hook_name: 'init',
            callback: [PostType::getInstance(), 'registerCustomPostType']
        );
    }

    /**
     * Initializing our filter
     */
    public function initFilter(): void {
        add_filter(
            hook_name: 'plugin_row_meta',
            callback: [$this, 'addPluginRowMeta'],
            accepted_args: 2
        );

        add_filter(
            hook_name: 'template_include',
            callback: [PostType::getInstance(), 'templateLoader']
        );
        add_filter(
            hook_name: 'page_template',
            callback: [PostType::getInstance(), 'registerPageTemplate']
        );

        add_filter(
            hook_name: 'post_type_link',
            callback: [PostType::getInstance(), 'createPermalinks'],
            priority: 1,
            accepted_args: 2
        );
    }

    /**
     * Ading some links to the plugin row meta data
     *
     * @param array $links
     * @param string $file
     * @return array
     */
    public function addPluginRowMeta(array $links, string $file): array {
        if (str_contains($file, 'eve-online-intel-tool.php')) {
            $new_links = [
                'issue_tracker' => '<a href="https://github.com/ppfeufer/eve-online-intel-tool/issues" target="_blank" rel="noopener noreferer">GitHub Issue Tracker</a>',
                'support_discord' => '<a href="https://discord.gg/YymuCZa" target="_blank" rel="noopener noreferer">Support Discord</a>'
            ];

            $links = array_merge($links, $new_links);
        }

        return $links;
    }

    /**
     * Adding noindex and nofollow meta
     */
    public function noindexForIntelPages(): void {
        if (PostType::getInstance()->isPostTypePage() === true) {
            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
        }
    }

    /**
     * Adding a meta description
     */
    public function setMetaDescription(): void {
        if (PostType::getInstance()->isPostTypePage() === true) {
            echo '<meta name="description" content="' . __('Intel tool for EVE Online. Parse and share directional scans, fleet compositions and chat scans.', 'eve-online-intel-tool') . '">';
        }
    }

    /**
     * Hook: flushRewriteRulesOnActivation
     * Fired on: register_activation_hook
     */
    public function registerPostTypeOnActivation(): void {
        PostType::getInstance()->registerCustomPostType();

        flush_rewrite_rules();
    }

    /**
     * Hook: flushRewriteRulesOnDeactivation
     * Fired on: register_deactivation_hook
     */
    public function unregisterPostTypeOnDeactivation(): void {
        PostType::getInstance()->unregisterCustomPostType();

        flush_rewrite_rules();
    }

    /**
     * Removing the DB version on plugin decativation
     * Issue: https://github.com/ppfeufer/eve-online-killboard-widget/issues/50
     */
    public function removeDatabaseVersionOnDeactivation(): void {
        delete_option(UpdateHelper::getInstance()->getDatabaseFieldName());
    }
}
