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

class RemoteHelper extends AbstractSingleton {
    /**
     * Getting data from a remote source
     *
     * @param string $url
     * @param string $method
     * @param array $parameter
     * @return string|null
     */
    public function getRemoteData(string $url, string $method = 'get', array $parameter = []): ?string {
        $returnValue = null;
        $params = '';

        switch ($method) {
            case 'get':
                if (count($parameter) > 0) {
                    $params = '?' . http_build_query(data: $parameter);
                }

                $remoteData = wp_remote_get(url: $url . $params);
                break;

            case 'post':
                $remoteData = wp_remote_post(url: $url, args: [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=utf-8'
                    ],
                    'body' => json_encode(value: $parameter),
                    'method' => 'POST'
                ]);
                break;
        }

        if (wp_remote_retrieve_response_code(response: $remoteData) === 200) {
            $returnValue = wp_remote_retrieve_body(response: $remoteData);
        }

        return $returnValue;
    }
}
