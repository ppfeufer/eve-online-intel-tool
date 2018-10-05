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

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseSystemKills')) {
    class UniverseSystemKills {
        /**
         * npcKills
         *
         * @var int
         */
        protected $npcKills = null;

        /**
         * podKills
         *
         * @var int
         */
        protected $podKills = null;

        /**
         * shipKills
         *
         * @var int
         */
        protected $shipKills = null;

        /**
         * systemId
         *
         * @var int
         */
        protected $systemId = null;

        /**
         * getNpcKills
         *
         * @return int
         */
        public function getNpcKills() {
            return $this->npcKills;
        }

        /**
         * setNpcKills
         *
         * @param int $npcKills
         */
        public function setNpcKills(int $npcKills) {
            $this->npcKills = $npcKills;
        }

        /**
         * getPodKills
         *
         * @return int
         */
        public function getPodKills() {
            return $this->podKills;
        }

        /**
         * setPodKills
         *
         * @param int $podKills
         */
        public function setPodKills(int $podKills) {
            $this->podKills = $podKills;
        }

        /**
         * getShipKills
         *
         * @return int
         */
        public function getShipKills() {
            return $this->shipKills;
        }

        /**
         * setShipKills
         *
         * @param int $shipKills
         */
        public function setShipKills(int $shipKills) {
            $this->shipKills = $shipKills;
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
        public function setSystemId(int $systemId) {
            $this->systemId = $systemId;
        }
    }
}
