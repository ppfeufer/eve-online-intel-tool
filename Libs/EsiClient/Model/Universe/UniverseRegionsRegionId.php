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

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseRegionsRegionId')) {
    class UniverseRegionsRegionId {
        /**
         * constellationId
         *
         * @var array
         */
        protected $constellations = null;

        /**
         * description
         *
         * @var string
         */
        protected $description = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * regionId
         *
         * @var int
         */
        protected $regionId = null;

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
            $this->constellations = $constellations;
        }

        /**
         * getDescription
         *
         * @return string
         */
        public function getDescription() {
            return $this->description;
        }

        /**
         * setDescription
         *
         * @param string $description
         */
        public function setDescription(string $description) {
            $this->description = $description;
        }

        /**
         * getName
         *
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * setName
         *
         * @param string $name
         */
        public function setName(string $name) {
            $this->name = $name;
        }

        /**
         * getRegionId
         *
         * @return int
         */
        public function getRegionId() {
            return $this->regionId;
        }

        /**
         * setRegionId
         *
         * @param int $regionId
         */
        public function setRegionId(int$regionId) {
            $this->regionId = $regionId;
        }
    }
}
