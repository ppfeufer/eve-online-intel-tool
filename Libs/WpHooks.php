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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs;

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
	} // public function __construct()

	/**
	 * Initialize all the needed hooks, filter, actions and so on
	 */
	public function init() {
		$this->initHooks();
		$this->initActions();
	} // public function init()

	/**
	 * Initialize our hooks
	 */
	public function initHooks() {
		\register_activation_hook($this->pluginFile, [$this, 'checkDatabaseForUpdates']);
		\register_activation_hook($this->pluginFile, [$this, 'flushRewriteRulesOnActivation']);

		\register_deactivation_hook($this->pluginFile, '\flush_rewrite_rules');
	} // public function initHook()

	/**
	 * Add our actions to WordPress
	 */
	public function initActions() {
		\add_action('wp_head', [$this, 'noindexForIntelPages']);
	} // public function initActions()

	/**
	 * Adding noindex and nofollow meta
	 */
	public function noindexForIntelPages() {
		if(PostType::isPostTypePage() === true) {
			echo '<meta name="robots" content="noindex, nofollow">' . "\n";
		} // if(PostType::isPostTypePage() === true)
	} // public function noindexForIntelPages()

	/**
	 * Hook: checkDatabaseForUpdates
	 * Fired on: register_activation_hook
	 */
	public function checkDatabaseForUpdates() {
		Helper\DatabaseHelper::getInstance()->checkDatabase($this->newDatabaseVersion);
	} // public function checkDatabaseForUpdates()

	/**
	 * Hook: flushRewriteRulesOnActivation
	 * Fired on: register_activation_hook
	 */
	public function flushRewriteRulesOnActivation() {
		PostType::registerCustomPostType();

		\flush_rewrite_rules();
	} // public function flushRewriteRulesOnActivation()
} // class WpHooks
