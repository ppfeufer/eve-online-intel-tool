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

namespace WordPress\EsiClient\Model\Universe\UniverseIds;

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseIds\Alliances')) {
    class Alliances {
        /**
         * id
         *
         * @var int
         */
        protected $id = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * getId
         *
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * setId
         *
         * @param int $id
         */
        public function setId(int $id) {
            $this->id = $id;
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
    }
}
