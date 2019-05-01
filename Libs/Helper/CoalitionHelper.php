<?php

/*
 * Copyright (C) 2019 ppfeufer
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

class CoalitionHelper extends AbstractSingleton {
    /**
     * Coalition API URL
     *
     * @var string
     */
    protected $coalitionApiUrl = 'http://rischwa.net/api/coalitions/current';

    /**
     * Database Helper
     *
     * @var DatabaseHelper
     */
    private $databaseHelper = null;

    /**
     * Remote Helper
     *
     * @var RemoteHelper
     */
    private $remoteHelper = null;

    /**
     * The Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->databaseHelper = DatabaseHelper::getInstance();
        $this->remoteHelper = RemoteHelper::getInstance();
    }

    public function getCoalitionInformation() {
        $coalitionData = $this->databaseHelper->getCachedEsiDataFromDb('api/coalitions/current');

        if(\is_null($coalitionData)) {
            $coalitionData = \json_decode($this->remoteHelper->getRemoteData($this->coalitionApiUrl));

            if(!\is_null($coalitionData)) {
                $coalitionInformation = [];

                foreach($coalitionData->coalitions as $coalitionDetails) {
                    $coalitionInformation[$coalitionDetails->_id] = $coalitionDetails;
                }

                $this->databaseHelper->writeEsiCacheDataToDb([
                    'api/coalitions/current',
                    \maybe_serialize($coalitionInformation),
                    \strtotime('+1 day')
                ]);

                $coalitionData = $this->databaseHelper->getCachedEsiDataFromDb('api/coalitions/current');
            }
        }

        return $coalitionData;
    }
}
