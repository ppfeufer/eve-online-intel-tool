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

namespace WordPress\EsiClient\Model\Corporation;

if(!\class_exists('\WordPress\EsiClient\Model\Corporation\CorporationsCorporationId')) {
    class CorporationsCorporationId {
        /**
         * allianceId
         *
         * @var inr
         */
        protected $allianceId = null;

        /**
         * ceoId
         *
         * @var int
         */
        protected $ceoId = null;

        /**
         * creatorId
         *
         * @var int
         */
        protected $creatorId = null;

        /**
         * dateFounded
         *
         * @var \DateTime
         */
        protected $dateFounded = null;

        /**
         * description
         *
         * @var string
         */
        protected $description = null;

        /**
         * factionId
         *
         * @var int
         */
        protected $factionId = null;

        /**
         * homeStationId
         *
         * @var int
         */
        protected $homeStationId = null;

        /**
         * memberCount
         *
         * @var int
         */
        protected $memberCount = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * shares
         *
         * @var int
         */
        protected $shares = null;
        /**
         * taxRate
         *
         * @var float
         */
        protected $taxRate = null;

        /**
         * ticker
         *
         * @var string
         */
        protected $ticker = null;

        /**
         * url
         *
         * @var string
         */
        protected $url = null;

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
         * getCeoId
         *
         * @return int
         */
        public function getCeoId() {
            return $this->ceoId;
        }

        /**
         * setCeoId
         *
         * @param int $ceoId
         */
        public function setCeoId(int $ceoId) {
            $this->ceoId = $ceoId;
        }

        /**
         * getCreatorId
         *
         * @return int
         */
        public function getCreatorId() {
            return $this->creatorId;
        }

        /**
         * setCreatorId
         *
         * @param int $creatorId
         */
        public function setCreatorId(int $creatorId) {
            $this->creatorId = $creatorId;
        }

        /**
         * getDateFounded
         *
         * @return \DateTime
         */
        public function getDateFounded() {
            return $this->dateFounded;
        }

        /**
         * setDateFounded
         *
         * @param \DateTime $dateFounded
         */
        public function setDateFounded(\DateTime $dateFounded) {
            $this->dateFounded = $dateFounded;
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
         * getHomeStationId
         *
         * @return int
         */
        public function getHomeStationId() {
            return $this->homeStationId;
        }

        /**
         * setHomeStationId
         *
         * @param int $homeStationId
         */
        public function setHomeStationId(int $homeStationId) {
            $this->homeStationId = $homeStationId;
        }

        /**
         * getMembercount
         *
         * @return int
         */
        public function getMembercount() {
            return $this->memberCount;
        }

        /**
         * setMemberCount
         *
         * @param int $memberCount
         */
        public function setMemberCount(int $memberCount) {
            $this->memberCount = $memberCount;
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
         * getShares
         *
         * @return int
         */
        public function getShares() {
            return $this->shares;
        }

        /**
         * setShares
         *
         * @param int $shares
         */
        public function setShares(int $shares) {
            $this->shares = $shares;
        }

        /**
         * getTaxRate
         *
         * @return float
         */
        public function getTaxRate() {
            return $this->taxRate;
        }

        /**
         * setTaxRate
         *
         * @param float $taxRate
         */
        public function setTaxRate(float $taxRate) {
            $this->taxRate = $taxRate;
        }

        /**
         * getTicker
         *
         * @return string
         */
        public function getTicker() {
            return $this->ticker;
        }

        /**
         * setTicker
         *
         * @param string $ticker
         */
        public function setTicker(string $ticker) {
            $this->ticker = $ticker;
        }

        /**
         * getUrl
         *
         * @return string
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * setUrl
         *
         * @param string $url
         */
        public function setUrl(string $url) {
            $this->url = $url;
        }
    }
}
