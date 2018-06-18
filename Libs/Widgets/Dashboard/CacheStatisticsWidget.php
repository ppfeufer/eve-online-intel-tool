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
    private $databaseHelper = null;

    public function __construct() {
        $this->databaseHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\DatabaseHelper::getInstance();

        $this->init();
    }

    public function init() {
        \add_action('wp_dashboard_setup', [$this, 'addDashboardWidget']);
    }

    public function addDashboardWidget() {
        \wp_add_dashboard_widget('eve-intel-tool-dashboard-widget-cache-statistics', \__('EVE Intel Tool :: Cache Statistics', 'eve-online-intel-tool'), [$this, 'renderDashboardWidget']);
    }

    public function renderDashboardWidget() {
        echo '<p>' . \__('Your EVE intel database cache', 'eve-online-intel-tool') . '</p>';
        echo '<p>';
        echo '<span class="eve-intel-widget-row">';
        echo '<span class="eve-intel-widget-column eve-intel-column-2">'
        . $this->renderPilotsRowHtml()
        . $this->renderCorporationsRowHtml()
        . '</span>';
        echo '<span class="eve-intel-widget-column eve-intel-column-2">'
        . $this->renderAlliancesRowHtml()
        . $this->renderShipsRowHtml()
        . '</span>';
        echo '</span>';

        echo '<span class="eve-intel-widget-row">';
        echo '<span class="eve-intel-widget-column eve-intel-column-2">'
        . $this->renderSystemsRowHtml()
        . $this->renderConstellationsRowHtml()
        . '</span>';
        echo '<span class="eve-intel-widget-column eve-intel-column-2">'
        . $this->renderRegionsRowHtml()
        . '</span>';
        echo '</span>';
        echo '<p>';
    }

    /**
     * Render the HTML part for the pilots row
     *
     * @return string
     */
    private function renderPilotsRowHtml() {
        $numberOfPilots = \number_format($this->databaseHelper->getNumberOfPilotsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Pilots', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfPilots . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the corporation row
     *
     * @return string
     */
    private function renderCorporationsRowHtml() {
        $numberOfCorporations = \number_format($this->databaseHelper->getNumberOfCorporationsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Corporations', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfCorporations . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the alliance row
     *
     * @return string
     */
    private function renderAlliancesRowHtml() {
        $numberOfAlliances = \number_format($this->databaseHelper->getNumberOfAlliancesInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Alliances', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfAlliances . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the ships row
     *
     * @return string
     */
    private function renderShipsRowHtml() {
        $numberOfShips = \number_format($this->databaseHelper->getNumberOfShipsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Ships', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfShips . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the systems row
     *
     * @return string
     */
    private function renderSystemsRowHtml() {
        $numberOfSystems = \number_format($this->databaseHelper->getNumberOfSystemsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Systems', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfSystems . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the constellations row
     *
     * @return string
     */
    private function renderConstellationsRowHtml() {
        $numberOfConstellations = \number_format($this->databaseHelper->getNumberOfConstellationsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Constellations', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfConstellations . '</span>'
            . '</span>';
    }

    /**
     * Render the HTML part for the regions row
     *
     * @return string
     */
    private function renderRegionsRowHtml() {
        $numberOfRegions = \number_format($this->databaseHelper->getNumberOfRegionsInDatabase(), 0, ',', '.');

        return '<span class="eve-intel-widget-row">'
            . '<span class="eve-intel-widget-column eve-intel-column-3-2"><strong>' . \__('Regions', 'eve-online-intel-tool') . ':</strong></span>'
            . '<span class="eve-intel-widget-column eve-intel-widget-number eve-intel-widget-align-right eve-intel-column-3-1">' . $numberOfRegions . '</span>'
            . '</span>';
    }
}
