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

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

\defined('ABSPATH') or die();

class ImageHelper extends AbstractSingleton {
    /**
     * base URL to CCP's image server
     *
     * @var var
     */
    public $imageserverUrl = 'https://images.evetech.net/';

    /**
     * Array with possible end point on CCP's image server
     *
     * @var array
     */
    public $imageserverEndpoints = null;

    /**
     * The Construtor
     */
    protected function __construct() {
        parent::__construct();

        $this->imageserverEndpoints = [
            'alliance' => 'alliances/%d/logo',
            'corporation' => 'corporations/%d/logo',
            'character' => 'characters/%d/portrait',
            'typeIcon' => 'types/%d/icon',
            'typeRender' => 'types/%d/render'
        ];
    }

    /**
     * Assigning Imagesever Endpoints
     */
    public function getImageserverEndpoints() {
        return $this->imageserverEndpoints;
    }

    /**
     * Getting the EVE API Url
     *
     * @param string $type
     * @return string The EVE API Url
     */
    public function getImageServerUrl(string $type = null) {
        $endpoint = '';

        if($type !== null) {
            $endpoint = $this->imageserverEndpoints[$type];
        }

        return $this->imageserverUrl . $endpoint;
    }
}
