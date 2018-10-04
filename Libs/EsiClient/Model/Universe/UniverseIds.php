<?php

/*
 * Copyright (C) 2018 ppfeufer
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

namespace WordPress\EsiClient\Model\Universe;

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseIds')) {
    class UniverseIds {
        /**
         * agents
         *
         * @var array
         */
        protected $agents = null;

        /**
         * alliances
         *
         * @var array
         */
        protected $alliances = null;

        /**
         * characters
         *
         * @var array
         */
        protected $characters = null;

        /**
         * constellations
         *
         * @var array
         */
        protected $constellations = null;

        /**
         * corporations
         *
         * @var array
         */
        protected $corporations = null;

        /**
         * factions
         *
         * @var array
         */
        protected $factions = null;

        /**
         * inventoryTypes
         *
         * @var array
         */
        protected $inventoryTypes = null;

        /**
         * regions
         *
         * @var array
         */
        protected $regions = null;

        /**
         * stations
         *
         * @var array
         */
        protected $stations = null;

        /**
         * systems
         *
         * @var array
         */
        protected $systems = null;

        /**
         * getAgents
         *
         * @return array
         */
        public function getAgents() {
            return $this->agents;
        }

        /**
         * setAgents
         *
         * @param array $agents
         */
        public function setAgents(array $agents) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->agents = $mapper->mapArray($agents, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Agents');
        }

        /**
         * getAlliances
         *
         * @return array
         */
        public function getAlliances() {
            return $this->alliances;
        }

        /**
         * setAlliances
         *
         * @param array $alliances
         */
        public function setAlliances(array $alliances) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->alliances = $mapper->mapArray($alliances, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Alliances');
        }

        /**
         * getCharacters
         *
         * @return array
         */
        public function getCharacters() {
            return $this->characters;
        }

        /**
         * setCharacters
         *
         * @param array $characters
         */
        public function setCharacters(array $characters) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->characters = $mapper->mapArray($characters, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Characters');
        }

        /**
         * getConstellations
         *
         * @return array
         */
        public function getConstellations() {
            return $this->constellations;
        }

        /**
         * setConstellations
         *
         * @param array $constellations
         */
        public function setConstellations(array $constellations) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->constellations = $mapper->mapArray($constellations, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Constellations');
        }

        /**
         * getCorporations
         *
         * @return array
         */
        public function getCorporations() {
            return $this->corporations;
        }

        /**
         * setCorporations
         *
         * @param array $corporations
         */
        public function setCorporations(array $corporations) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->corporations = $mapper->mapArray($corporations, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Corporations');
        }

        /**
         * getFactions
         *
         * @return array
         */
        public function getFactions() {
            return $this->factions;
        }

        /**
         * setFactions
         *
         * @param array $factions
         */
        public function setFactions(array $factions) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->factions = $mapper->mapArray($factions, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Factions');
        }

        /**
         * getInventoryTypes
         *
         * @return array
         */
        public function getInventoryTypes() {
            return $this->inventoryTypes;
        }

        /**
         * setInventoryTypes
         *
         * @param array $inventoryTypes
         */
        public function setInventoryTypes(array $inventoryTypes) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->inventoryTypes = $mapper->mapArray($inventoryTypes, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\InventoryTypes');
        }

        /**
         * getRegions
         *
         * @return array
         */
        public function getRegions() {
            return $this->regions;
        }

        /**
         * setRegions
         *
         * @param array $regions
         */
        public function setRegions(array $regions) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->regions = $mapper->mapArray($regions, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Regions');
        }

        /**
         * getStations
         *
         * @return array
         */
        public function getStations() {
            return $this->stations;
        }

        /**
         * setStations
         *
         * @param array $stations
         */
        public function setStations(array $stations) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->stations = $mapper->mapArray($stations, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Stations');
        }

        /**
         * getSystems
         *
         * @return array
         */
        public function getSystems() {
            return $this->systems;
        }

        /**
         * setSystems
         *
         * @param array $systems
         */
        public function setSystems(array $systems) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->systems = $mapper->mapArray($systems, [], '\\WordPress\EsiClient\Model\Universe\UniverseIds\Systems');
        }
    }
}
