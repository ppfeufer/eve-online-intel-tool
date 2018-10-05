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

if(!\class_exists('\WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\Attacker')) {
    class Attacker {
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
         * damageDone
         *
         * @var int
         */
        protected $damageDone = null;

        /**
         * factionId
         *
         * @var int
         */
        protected $factionId = null;

        /**
         * finalBlow
         *
         * Was the attacker the one to achieve the final blow
         *
         * @var bool
         */
        protected $finalBlow = false;

        /**
         * securityStatus
         *
         * Security status for the attacker
         *
         * @var float
         */
        protected $securityStatus = null;

        /**
         * shipTypeId
         *
         * What ship was the attacker flying
         *
         * @var int
         */
        protected $shipTypeId = null;

        /**
         * weaponTypeId
         *
         * What weapon was used by the attacker for the kill
         *
         * @var int
         */
        protected $weaponTypeId = null;

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
        public function setAllianceId(int $allianceId) {
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
        public function setCharacterId(int $characterId) {
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
        public function setCorporationId(int $corporationId) {
            $this->corporationId = $corporationId;
        }

        /**
         * getDamageDone
         *
         * @return int
         */
        public function getDamageDone() {
            return $this->damageDone;
        }

        /**
         * setDamageDone
         *
         * @param int $damageDone
         */
        public function setDamageDone(int $damageDone) {
            $this->damageDone = $damageDone;
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
        public function setFactionId(int $factionId) {
            $this->factionId = $factionId;
        }

        /**
         * getFinalBlow
         *
         * Was the attacker the one to achieve the final blow
         *
         * @return bool
         */
        public function getFinalBlow() {
            return $this->finalBlow;
        }

        /**
         * setFinalBlow
         *
         * Was the attacker the one to achieve the final blow
         *
         * @param bool $finalBlow
         */
        public function setFinalBlow(bool $finalBlow) {
            $this->finalBlow = $finalBlow;
        }

        /**
         * getSecurityStatus
         *
         * Security status for the attacker
         *
         * @return float
         */
        public function getSecurityStatus() {
            return $this->securityStatus;
        }

        /**
         * setSecurityStatus
         *
         * Security status for the attacker
         *
         * @param float $securityStatus
         */
        public function setSecurityStatus(float $securityStatus) {
            $this->securityStatus = $securityStatus;
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
        public function setShipTypeId(int $shipTypeId) {
            $this->shipTypeId = $shipTypeId;
        }

        /**
         * getWaeponTypeId
         *
         * What weapon was used by the attacker for the kill
         *
         * @return int
         */
        public function getWaeponTypeId() {
            return $this->weaponTypeId;
        }

        /**
         * setWeaponTypeId
         *
         * What weapon was used by the attacker for the kill
         *
         * @param int $weaponTypeId
         */
        public function setWeaponTypeId(int $weaponTypeId) {
            $this->weaponTypeId = $weaponTypeId;
        }
    }
}
