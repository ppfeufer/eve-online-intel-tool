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
     * Find type data by type ID
     *
     * @param int $typeID
     * @return object
     */
    public function findTypeById($typeID) {
        $this->esiRoute = 'universe/types/' . $typeID . '/?datasource=tranquility';

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
        $this->esiRoute = 'universe/groups/' . $groupID . '/?datasource=tranquility';

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
        $this->esiRoute = 'universe/systems/' . $systemID . '/?datasource=tranquility';

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
        $this->esiRoute = 'universe/constellations/' . $constellationID . '/?datasource=tranquility';

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
        $this->esiRoute = 'universe/regions/' . $regionID . '/?datasource=tranquility';

        $regionData = $this->callEsi();

        return $regionData;
    }

    public function getIdFromName(array $names) {
        $this->esiRoute = 'universe/ids/?datasource=tranquility';

        $nameData = $this->callEsi('post', $names);

        return $nameData;
    }
}
