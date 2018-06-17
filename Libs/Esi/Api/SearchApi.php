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

class SearchApi extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Esi\Swagger {
    public function findIdByName($name, $type) {
        $this->esiRoute = 'search/?categories=' . $type . '&datasource=tranquility&language=en-us&search=' . $name . '&strict=true';

        return $this->callEsi();
    }

    /**
     * Find character ID by name
     *
     * @param string $name
     * @return stdClass Object
     */
    public function findCharacterIdByName($name) {
        $this->esiRoute = 'search/?categories=character&datasource=tranquility&language=en-us&search=' . $name . '&strict=true';

        return $this->callEsi();
    }
}
