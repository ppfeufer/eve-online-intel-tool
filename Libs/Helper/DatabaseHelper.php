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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

class DatabaseHelper extends AbstractSingleton {
    /**
     * WordPress Database Instance
     *
     * @var \wpdb
     */
    private $wpdb = null;

    /**
     * Constructor
     *
     * @global \wpdb $wpdb
     */
    protected function __construct() {
        parent::__construct();

        global $wpdb;

        $this->wpdb = $wpdb;
    }

    /**
     * Getting cached Data from DB
     *
     * @param string $route
     * @return mixed Esi Object
     */
    public function getCachedEsiDataFromDb(string $route): mixed {
        $returnValue = null;

        $cacheResult = $this->wpdb->get_results(query: $this->wpdb->prepare(
            'SELECT * FROM ' . $this->wpdb->base_prefix . 'eve_online_esi_cache' . ' WHERE esi_route = %s AND valid_until > %s',
            [
                $route,
                time()
            ]
        ));

        if ($cacheResult) {
            $returnValue = maybe_unserialize(data: $cacheResult['0']->value);
        }

        return $returnValue;
    }

    /**
     * Write cache data into the DB
     *
     * @param array $data ([esi_route, value, valid_until])
     * @return void
     */
    public function writeEsiCacheDataToDb(array $data): void {
        $this->wpdb->query(query: $this->wpdb->prepare(
            'REPLACE INTO ' . $this->wpdb->base_prefix . 'eve_online_esi_cache' . ' (esi_route, value, valid_until) VALUES (%s, %s, %s)',
            $data
        ));
    }
}
