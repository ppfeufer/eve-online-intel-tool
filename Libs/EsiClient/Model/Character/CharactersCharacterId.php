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

namespace WordPress\EsiClient\Model\Character;

if(!\class_exists('\WordPress\EsiClient\Model\Character\CharactersCharacterId')) {
    class CharactersCharacterId {
        /**
         * ancestryId
         *
         * @var int
         */
        protected $ancestryId = null;

        /**
         * birthday
         *
         * @var \DateTime
         */
        protected $birhday = null;

        /**
         * bloodlineId
         *
         * @var int
         */
        protected $bloodlineId = null;

        /**
         * corporationId
         *
         * @var int
         */
        protected $corporationId = null;

        /**
         * description
         *
         * @var string
         */
        protected $description = null;

        /**
         * gender
         *
         * @var string
         */
        protected $gender = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * raceId
         *
         * @var int
         */
        protected $raceId = null;

        /**
         * securityStatus
         *
         * @var float
         */
        protected $securityStatus = null;

        /**
         * getAncestryId
         *
         * @return int
         */
        public function getAncestryId() {
            return $this->ancestryId;
        }

        /**
         * setAncestryId
         *
         * @param int $ancestryId
         */
        public function setAncestryId(int $ancestryId) {
            $this->ancestryId = $ancestryId;
        }

        /**
         * getBirthday
         *
         * @return \DateTime
         */
        public function getBirthday() {
            return $this->birhday;
        }

        /**
         * setBirthday
         *
         * @param \DateTime $birthday
         */
        public function setBirthday(\DateTime $birthday) {
            $this->birhday = $birthday;
        }

        /**
         * getBloodlineId
         *
         * @return int
         */
        public function getBloodlineId() {
            return $this->bloodlineId;
        }

        /**
         * setBloodlineId
         *
         * @param int $bloodlineId
         */
        public function setBloodlineId(int $bloodlineId) {
            $this->bloodlineId = $bloodlineId;
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
            $this->description = \strip_tags($description);
        }

        /**
         * getGender
         *
         * @return string
         */
        public function getGender() {
            return $this->gender;
        }

        /**
         * setGender
         *
         * @param string $gender
         */
        public function setGender(string $gender) {
            $this->gender = $gender;
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
         * getRaceId
         *
         * @return int
         */
        public function getRaceId() {
            return $this->raceId;
        }

        /**
         * setRaceId
         *
         * @param int $raceId
         */
        public function setRaceId(int $raceId) {
            $this->raceId = $raceId;
        }

        /**
         * getSecurityStatus
         *
         * @return float
         */
        public function getSecurityStatus() {
            return $this->securityStatus;
        }

        /**
         * setSecurityStatus
         *
         * @param float $securityStatus
         */
        public function setSecurityStatus(float $securityStatus) {
            $this->securityStatus = $securityStatus;
        }
    }
}
