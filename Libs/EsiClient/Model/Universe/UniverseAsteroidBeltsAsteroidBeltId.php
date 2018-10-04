<?php

/*
 * Copyright (C) 2018 p.pfeufer
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

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseAsteroidBeltsAsteroidBeltId')) {
    class UniverseAsteroidBeltsAsteroidBeltId {
        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * position
         *
         * @var \WordPress\EsiClient\Model\Universe\UniverseAsteroidBeltsAsteroidBeltId\Position
         */
        protected $position = null;

        /**
         * systemId
         *
         * @var int
         */
        protected $systemId = null;

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
        public function setName($name) {
            $this->name = $name;
        }

        /**
         * getPosition
         *
         * @return \WordPress\EsiClient\Model\Universe\UniverseAsteroidBeltsAsteroidBeltId\Position
         */
        public function getPosition() {
            return $this->position;
        }

        /**
         * setPosition
         *
         * @param \WordPress\EsiClient\Model\Universe\UniverseAsteroidBeltsAsteroidBeltId\Position $position
         */
        public function setPosition(\WordPress\EsiClient\Model\Universe\UniverseAsteroidBeltsAsteroidBeltId\Position $position) {
            $this->position = $position;
        }

        /**
         * getSystemId
         *
         * @return int
         */
        public function getSystemId() {
            return $this->systemId;
        }

        /**
         * setSystemId
         *
         * @param int $systemId
         */
        public function setSystemId($systemId) {
            $this->systemId = $systemId;
        }
    }
}
