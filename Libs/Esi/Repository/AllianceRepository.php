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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Repository;

\defined('ABSPATH') or die();

class AllianceRepository extends \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        /**
         * Public information about an alliance
         */
        'alliances_allianceId' => 'alliances/{alliance_id}/?datasource=tranquility',
    ];

    /**
     * Public information about an alliance
     *
     * @param int $allianceID
     * @return \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Model\Alliance\AlliancesAllianceId
     */
    public function alliancesAllianceId($allianceID) {
        $returnValue = null;

        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['alliances_allianceId']);
        $this->setEsiRouteParameter([
            '/{alliance_id}/' => $allianceID
        ]);
        $this->setEsiVersion('v3');

        $allianceData = $this->callEsi();

        if(!\is_null($allianceData)) {
            $jsonMapper = new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Mapper\JsonMapper;
            $returnValue = $jsonMapper->map(\json_decode($allianceData), new \WordPress\Plugins\EveOnlineIntelTool\Libs\Esi\Model\Alliance\AlliancesAllianceId);
        }

        return $returnValue;
    }
}
