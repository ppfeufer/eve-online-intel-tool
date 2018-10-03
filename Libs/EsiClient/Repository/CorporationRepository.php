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

class CorporationRepository extends \WordPress\EsiClient\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        'corporations_corporationId' => 'corporations/{corporation_id}/?datasource=tranquility',
        'corporations_corporationId_alliancehistory' => 'corporations/{corporation_id}/alliancehistory/?datasource=tranquility',
        'corporations_corporationId_icons' => 'corporations/{corporation_id}/icons/?datasource=tranquility',
        'corporations_npccorps' => 'corporations/npccorps/?datasource=tranquility',
    ];

    /**
     * Public information about a corporation
     *
     * @param int $corporationID An EVE corporation ID
     * @return \WordPress\EsiClient\Model\Corporation\CorporationsCorporationId
     */
    public function corporationsCorporationId($corporationID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['corporations_corporationId']);
        $this->setEsiRouteParameter([
            '/{corporation_id}/' => $corporationID
        ]);
        $this->setEsiVersion('v4');

        return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Corporation\CorporationsCorporationId);
    }
}
