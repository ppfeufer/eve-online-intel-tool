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

class CharacterApi extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        'characters_characterId' => 'characters/{character_id}/?datasource=tranquility',
        'characters_portrait' => 'characters/{character_id}/portrait/?datasource=tranquility',
        'characters_affiliation' => 'characters/affiliation/?datasource=tranquility'
    ];

    /**
     * Find character data by charater ID
     *
     * @param int $characterID
     * @return object
     */
    public function findById($characterID) {
        $this->esiRoute = \preg_replace('/{character_id}/', $characterID, $this->esiEndpoints['characters_characterId']);
        $this->esiVersion = 'v4';

        $characterData = $this->callEsi();

        return $characterData;
    }

    /**
     * Find character affiliation
     *
     * @param array $characterIds
     * @return object
     */
    public function findAffiliation($characterIds = []) {
        $this->esiRoute = $this->esiEndpoints['characters_affiliation'];
        $this->esiVersion = 'v1';

        $affiliationData = $this->callEsi('post', $characterIds);

        return $affiliationData;
    }
}
