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
		$this->newDatabaseVersion = (isset($parameter['newDatabaseVersion'])) ? $parameter['newDatabaseVersion'] : null;

		$this->init();
	} // public function __construct()

	/**
	 * Initialize all the needed hooks, filter, actions and so on
	 */
	public function init() {
		$this->initHooks();
	} // public function init()

	/**
	 * Initialize our hooks
	 */
	public function initHooks() {
		\register_activation_hook(Helper\PluginHelper::getInstance()->getPluginPath('eve-online-intel-tool.php'), [$this, 'checkDatabaseForUpdates']);
	} // public function initHook()

	/**
	 * Hook: checkDatabaseForUpdates
	 * Fired on: register_activation_hook
	 */
	public function checkDatabaseForUpdates() {
		Helper\DatabaseHelper::getInstance()->checkDatabase($this->newDatabaseVersion);
	} // public function checkDatabaseForUpdates()
} // class WpHooks
