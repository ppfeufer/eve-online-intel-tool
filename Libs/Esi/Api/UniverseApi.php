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
namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Api;

\defined('ABSPATH') or die();

class UniverseApi extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        'universe_ids' => 'universe/ids/?datasource=tranquility',
        'universe_types_typeID' => 'universe/types/{type_id}/?datasource=tranquility',
        'universe_groups_groupID' => 'universe/groups/{group_id}/?datasource=tranquility',
        'universe_systems_systemID' => 'universe/systems/{system_id}/?datasource=tranquility',
        'universe_constellations_constellationID' => 'universe/constellations/{constellation_id}/?datasource=tranquility',
        'universe_regions_regionID' => 'universe/regions/{region_id}/?datasource=tranquility',
    ];

    /**
     * Find type data by type ID
     *
     * @param int $typeID
     * @return object
     */
    public function findTypeById($typeID) {
        $this->esiRoute = \preg_replace('/{type_id}/', $typeID, $this->esiEndpoints['universe_types_typeID']);
        $this->esiVersion = 'v3';

        $typeData = $this->callEsi();

        return $typeData;
    }

    /**
     * Fine group data by group ID
     *
     * @param int $groupID
     * @return object
     */
    public function findGroupById($groupID) {
        $this->esiRoute = \preg_replace('/{group_id}/', $groupID, $this->esiEndpoints['universe_groups_groupID']);
        $this->esiVersion = 'v1';

        $groupData = $this->callEsi();

        return $groupData;
    }

    /**
     * Fine system data by system ID
     *
     * @param int $systemID
     * @return object
     */
    public function findSystemById($systemID) {
        $this->esiRoute = \preg_replace('/{system_id}/', $systemID, $this->esiEndpoints['universe_systems_systemID']);
        $this->esiVersion = 'v4';

        $systemData = $this->callEsi();

        return $systemData;
    }

    /**
     * Fine constellation data by constellation ID
     *
     * @param int $constellationID
     * @return object
     */
    public function findConstellationById($constellationID) {
        $this->esiRoute = \preg_replace('/{constellation_id}/', $constellationID, $this->esiEndpoints['universe_constellations_constellationID']);
        $this->esiVersion = 'v1';

        $constellationData = $this->callEsi();

        return $constellationData;
    }

    /**
     * Fine region data by region ID
     *
     * @param int $regionID
     * @return object
     */
    public function findRegionById($regionID) {
        $this->esiRoute = \preg_replace('/{region_id}/', $regionID, $this->esiEndpoints['universe_regions_regionID']);
        $this->esiVersion = 'v1';

        $regionData = $this->callEsi();

        return $regionData;
    }

    public function getIdFromName(array $names) {
        $this->esiRoute = $this->esiEndpoints['universe_ids'];
        $this->esiVersion = 'v1';

        $nameData = $this->callEsi('post', $names);

        return $nameData;
    }
}
