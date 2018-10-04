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

namespace WordPress\EsiClient\Model\Killmails\KillmailsKillmailId;

if(!\class_exists('\WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Victim')) {
    class Victim {
        /**
         * allianceId
         *
         * @var int
         */
        protected $allianceId = null;

        /**
         * characterId
         *
         * @var int
         */
        protected $characterId = null;

        /**
         * corporationId
         *
         * @var int
         */
        protected $corporationId = null;

        /**
         * damageTaken
         *
         * @var int
         */
        protected $damageTaken = null;

        /**
         * factionId
         *
         * @var int
         */
        protected $factionId = null;

        /**
         * items
         *
         * @var array
         */
        protected $items = null;

        /**
         * position
         *
         * @var \WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Position
         */
        protected $position = null;

        /**
         * shipTypeId
         *
         * @var int
         */
        protected $shipTypeId = null;

        /**
         * getAllianceId
         *
         * @return int
         */
        public function getAllianceId() {
            return $this->allianceId;
        }

        /**
         * setAllianceId
         *
         * @param int $allianceId
         */
        public function setAllianceId($allianceId) {
            $this->allianceId = $allianceId;
        }

        /**
         * getCharacterId
         *
         * @return int
         */
        public function getCharacterId() {
            return $this->characterId;
        }

        /**
         * setCharacterId
         *
         * @param int $characterId
         */
        public function setCharacterId($characterId) {
            $this->characterId = $characterId;
        }

        /**
         * getCorporationId
         *
         * @return int
         */
        public function getCorporationId() {
            return $this->corporationId;
        }

        /**
         * setCorporationId
         *
         * @param int $corporationId
         */
        public function setCorporationId($corporationId) {
            $this->corporationId = $corporationId;
        }

        /**
         * getDamageTaken
         *
         * @return int
         */
        public function getDamageTaken() {
            return $this->damageTaken;
        }

        /**
         * setDamageTaken
         *
         * @param int $damageTaken
         */
        public function setDamageTaken($damageTaken) {
            $this->damageTaken = $damageTaken;
        }

        /**
         * getFactionId
         *
         * @return int
         */
        public function getFactionId() {
            return $this->factionId;
        }

        /**
         * setFactionId
         *
         * @param int $factionId
         */
        public function setFactionId($factionId) {
            $this->factionId = $factionId;
        }

        /**
         * getItems
         *
         * @return array
         */
        public function getItems() {
            return $this->items;
        }

        /**
         * setItems
         *
         * @param array $items
         */
        public function setItems(array $items) {
            $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

            $this->items = $mapper->mapArray($items, [], '\\WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Item');
        }

        /**
         * getPosition
         *
         * @return \WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Position
         */
        public function getPosition() {
            return $this->position;
        }

        /**
         * setPosition
         *
         * @param \WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Position $position
         */
        public function setPosition(\WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Position $position) {
            $this->position = $position;
        }

        /**
         * getShipTypeId
         *
         * What ship was the attacker flying
         *
         * @return int
         */
        public function getShipTypeId() {
            return $this->shipTypeId;
        }

        /**
         * setShipTypeId
         *
         * What ship was the attacker flying
         *
         * @param int $shipTypeId
         */
        public function setShipTypeId($shipTypeId) {
            $this->shipTypeId = $shipTypeId;
        }
    }
}
