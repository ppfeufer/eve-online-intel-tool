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
namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Api;

\defined('ABSPATH') or die();

class UniverseApi extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Swagger {
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
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['universe_types_typeID']);
        $this->setEsiRouteParameter([
            '/{type_id}/' => $typeID
        ]);
        $this->setEsiVersion('v3');

        $typeData = $this->callEsi();

        return $typeData;
    }

    /**
     * Find group data by group ID
     *
     * @param int $groupID
     * @return object
     */
    public function findGroupById($groupID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['universe_groups_groupID']);
        $this->setEsiRouteParameter([
            '/{group_id}/' => $groupID
        ]);
        $this->setEsiVersion('v1');

        $groupData = $this->callEsi();

        return $groupData;
    }

    /**
     * Find system data by system ID
     *
     * @param int $systemID
     * @return object
     */
    public function findSystemById($systemID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['universe_systems_systemID']);
        $this->setEsiRouteParameter([
            '/{system_id}/' => $systemID
        ]);
        $this->setEsiVersion('v4');

        $systemData = $this->callEsi();

        return $systemData;
    }

    /**
     * Find constellation data by constellation ID
     *
     * @param int $constellationID
     * @return object
     */
    public function findConstellationById($constellationID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($constellationID, $this->esiEndpoints['universe_constellations_constellationID']);
        $this->setEsiRouteParameter([
            '/{constellation_id}/' => $constellationID
        ]);
        $this->setEsiVersion('v1');

        $constellationData = $this->callEsi();

        return $constellationData;
    }

    /**
     * Find region data by region ID
     *
     * @param int $regionID
     * @return object
     */
    public function findRegionById($regionID) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['universe_regions_regionID']);
        $this->setEsiRouteParameter([
            '/{region_id}/' => $regionID
        ]);
        $this->setEsiVersion('v1');

        $regionData = $this->callEsi();

        return $regionData;
    }

    /**
     * Get the ID of a name in EVE
     *
     * @param array $names
     * @return object
     */
    public function getIdFromName(array $names) {
        $this->setEsiMethod('post');
        $this->setEsiPostParameter($names);
        $this->setEsiRoute($this->esiEndpoints['universe_ids']);
        $this->setEsiVersion('v1');

        $nameData = $this->callEsi();

        return $nameData;
    }
}
