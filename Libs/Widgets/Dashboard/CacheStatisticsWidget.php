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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Widgets\Dashboard;

\defined('ABSPATH') or die();

/**
 * Dashboard Widget: Cache Statisctics
 */
class CacheStatisticsWidget {
	/**
	 * Database Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\DatabaseHelper
	 */
	private $dbHelper = null;

	public function __construct() {
		$this->dbHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\DatabaseHelper::getInstance();

		$this->init();
	} // public function __construct()

	public function init() {
		\add_action('wp_dashboard_setup', [$this, 'addDashboardWidget']);
	} // public function init()

	public function addDashboardWidget() {
		\wp_add_dashboard_widget('eve-intel-tool-dashboard-widget-cache-statistics', \__('EVE Intel Tool :: Cache Statistics', 'eve-online-intel-tool'), [$this, 'renderDashboardWidget']);
	} // public function addDashboardWidget()

	public function renderDashboardWidget() {
		$numberOfPilots = \number_format($this->dbHelper->getNumberOfPilotsInDatabase(), 0, ',', '.');
		$numberOfCorporations = \number_format($this->dbHelper->getNumberOfCorporationsInDatabase(), 0, ',', '.');
		$numberOfAlliances = \number_format($this->dbHelper->getNumberOfAlliancesInDatabase(), 0, ',', '.');
		$numberOfShips = \number_format($this->dbHelper->getNumberOfShipsInDatabase(), 0, ',', '.');

		echo '<p>' . \__('Your EVE intel database cache', 'eve-online-intel-tool') . '</p>';
		echo '<p>';
		echo '<span class="eve-intel-widget-column eve-intel-column-2"><span class="eve-intel-widget-row"><strong>' . \__('Pilots', 'eve-online-intel-tool') . ':</strong> ' .  $numberOfPilots . '</span><span class="eve-intel-widget-row"><strong>' . \__('Corporations', 'eve-online-intel-tool') . ':</strong> ' . $numberOfCorporations . '</span></span>';
		echo '<span class="eve-intel-widget-column eve-intel-column-2"><span class="eve-intel-widget-row"><strong>' . \__('Alliances', 'eve-online-intel-tool') . ':</strong> ' .  $numberOfAlliances . '</span><span class="eve-intel-widget-row"><strong>' . \__('Ships', 'eve-online-intel-tool') . ':</strong> ' . $numberOfShips . '</span></span>';
		echo '<p>';
	} // public function renderDashboardWidget()
} // class CacheStatisticsWidget
