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

namespace WordPress\EsiClient\Model\Alliance;

if(!\class_exists('\WordPress\EsiClient\Model\Alliance\AlliancesAllianceId')) {
    class AlliancesAllianceId {
        /**
         * creatorCorpId
         *
         * @var int
         */
        protected $creatorCorporationId = null;

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
         * executorCorpId
         *
         * @var int
         */
        protected $executorCorporationId = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * ticker
         *
         * @var string
         */
        protected $ticker = null;

        /**
         * getCreatorCorpId
         *
         * @return int
         */
        public function getCreatorCorporationId() {
            return $this->creatorCorporationId;
        }

        /**
         * setCreatorCorpId
         *
         * @param int $creatorCorpId
         */
        public function setCreatorCorporationId($creatorCorpId) {
            $this->creatorCorporationId = $creatorCorpId;
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
        public function setCreatorId($creatorId) {
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
         * getExecutorCorpId
         *
         * @return int
         */
        public function getExecutorCorporationId() {
            return $this->executorCorporationId;
        }

        /**
         * setExecutorCorpId
         *
         * @param int $executorCorpId
         */
        public function setExecutorCorporationId($executorCorpId) {
            $this->executorCorporationId = $executorCorpId;
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
        public function setName($name) {
            $this->name = $name;
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
        public function setTicker($ticker) {
            $this->ticker = $ticker;
        }
    }
}
