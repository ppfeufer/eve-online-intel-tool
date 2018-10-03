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

namespace WordPress\EsiClient\Repository;

\defined('ABSPATH') or die();

class AllianceRepository extends \WordPress\EsiClient\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        'alliances' => 'alliances/?datasource=tranquility',
        'alliances_allianceId' => 'alliances/{alliance_id}/?datasource=tranquility',
        'alliances_allianceId_corporations' => 'alliances/{alliance_id}/corporations/?datasource=tranquility',
        'alliances_allianceId_icons' => 'alliances/{alliance_id}/icons/?datasource=tranquility'
    ];

    /**
     * Public information about an alliance
     *
     * @param int $allianceID An EVE alliance ID
     * @return \WordPress\EsiClient\Model\Alliance\AlliancesAllianceId
     */
    public function alliancesAllianceId($allianceID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['alliances_allianceId']);
        $this->setEsiRouteParameter([
            '/{alliance_id}/' => $allianceID
        ]);
        $this->setEsiVersion('v3');

        return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Alliance\AlliancesAllianceId);
    }
}
