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

/**
 * Helper Class for manipulating and/or checking strings
 */
class StructureHelper extends AbstractSingleton {
    /**
     * Creating an array of Upwell structure IDs
     *
     * @return array Upwell structure IDs
     */
    public function getUpwellStructureIds() {
        $returnValue = \array_merge(
            $this->getCitadelIds(),
            $this->getFactionFortizarIds(),
            $this->getEngeneeringComplexIds(),
            $this->getRefineryIds(),
            $this->getNavigationalStructureIds()
        );

        return $returnValue;
    }

    /**
     * Get all "normal" Citadel IDs
     *
     * @return array
     */
    public function getCitadelIds() {
        return [
            /**
             * Citadels
             */
            35832, // Astrahus
            35833, // Fortizar
            35834, // Keepstar
            40340, // Upwell Palatine Keepstar
        ];
    }

    /**
     * Get all Faction Fortizar IDs
     *
     * @return array
     */
    public function getFactionFortizarIds() {
        return [
            /**
             * Faction Fortizars (Former Outposts)
             */
            47512, // 'Moreau' Fortizar
            47513, // 'Draccous' Fortizar
            47514, // 'Horizon' Fortizar
            47515, // 'Marginis' Fortizar
            47516, // 'Prometheus' Fortizar
        ];
    }

    /**
     * Get all Engeneering Complex IDs
     *
     * @return array
     */
    public function getEngeneeringComplexIds() {
        return [
            /**
             * Engeneering Complexes
             */
            35825, // Raitaru
            35826, // Azbel
            35827, // Sotiyo
        ];
    }

    /**
     * Get all Refinery IDs
     *
     * @return array
     */
    public function getRefineryIds() {
        return [
            /**
             * Refineries
             */
            35835, // Athanor
            35836, // Tatara
        ];
    }

    /**
     * Get all Navigational Structure IDs
     *
     * @return array
     */
    public function getNavigationalStructureIds() {
        return [
            /**
             * Navigational Structures
             */
            35840, // Pharolux Cyno Beacon
            35841, // Ansiblex Jump Gate
            37534, // Tenebrex Cyno Jammer
        ];
    }
}
