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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Ajax;

use WordPress\EsiClient\Model\Meta\Status;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\EsiHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Interfaces\AjaxInterface;

class EsiStatus implements AjaxInterface {
    /**
     * Constructor
     */
    public function __construct() {
        $this->initActions();
    }

    /**
     * Initialize WP Actions
     *
     * @return void
     */
    public function initActions(): void {
        add_action(hook_name: 'wp_ajax_nopriv_get-esi-status', callback: [$this, 'ajaxAction']);
        add_action(hook_name: 'wp_ajax_get-esi-status', callback: [$this, 'ajaxAction']);
    }

    /**
     * Ajax Action
     *
     * @return void
     */
    public function ajaxAction(): void {
        $esiStatus = EsiHelper::getInstance()->getEsiStatusLatest();
        $countTotalEndpoints = 0;
        $countGreenEndpoints = 0;
        $countYellowEndpoints = 0;
        $countRedEndpoints = 0;
        $percentageGreen = 0;
        $percentageYellow = 0;
        $percentageRed = 0;

        if (!is_null($esiStatus)) {
            $countTotalEndpoints = count($esiStatus);

            foreach ($esiStatus as $endpointStatus) {
                /* @var $endpointStatus Status */
                switch ($endpointStatus->getStatus()) {
                    case 'green':
                        $countGreenEndpoints++;
                        break;

                    case 'yellow':
                        $countYellowEndpoints++;
                        break;

                    case 'red':
                        $countRedEndpoints++;
                        break;
                }
            }

            $percentageGreen = number_format(num: 100 / $countTotalEndpoints * $countGreenEndpoints, decimals: 2);
            $percentageYellow = number_format(num: 100 / $countTotalEndpoints * $countYellowEndpoints, decimals: 2);
            $percentageRed = number_format(num: 100 / $countTotalEndpoints * $countRedEndpoints, decimals: 2);
        }

        wp_send_json(response: [
            'countTotalEndpoints' => $countTotalEndpoints,
            'countGreenEndpoints' => $countGreenEndpoints,
            'countYellowEndpoints' => $countYellowEndpoints,
            'countRedEndpoints' => $countRedEndpoints,
            'percentageGreen' => $percentageGreen,
            'percentageYellow' => $percentageYellow,
            'percentageRed' => $percentageRed
        ]);

        // always exit this API function
        exit;
    }
}
