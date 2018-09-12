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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

/**
 * Helper Class for manipulating and/or checking strings
 */
class StructureHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
    /**
     * Creating an array of Upwell structure IDs
     *
     * @return array Upwell structure IDs
     */
    public function getUpwellStructureIds() {
        return [
            /**
             * Citadels
             */
            '35832', // Astrahus
            '35833', // Fortizar
            '35834', // Keepstar
            '40340', // Upwell Palatine Keepstar

            /**
             * Faction Fortizars (Former Outposts)
             */
            '47512', // 'Moreau' Fortizar
            '47513', // 'Draccous' Fortizar
            '47514', // 'Horizon' Fortizar
            '47515', // 'Marginis' Fortizar
            '47516', // 'Prometheus' Fortizar

            /**
             * Engeneering Complexes
             */
            '35825', // Raitaru
            '35826', // Azbel
            '35827', // Sotiyo

            /**
             * Refineries
             */
            '35835', // Athanor
            '35836', // Tatara
        ];
    }
}