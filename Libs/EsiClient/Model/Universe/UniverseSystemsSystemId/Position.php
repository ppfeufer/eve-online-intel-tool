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

namespace WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId;

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Position')) {
    class Position {
        /**
         * x coordinate
         *
         * @var double
         */
        protected $x = null;

        /**
         * y coordinate
         *
         * @var double
         */
        protected $y = null;

        /**
         * z coordinate
         *
         * @var double
         */
        protected $z = null;

        /**
         * getX
         *
         * @return double
         */
        public function getX() {
            return $this->x;
        }

        /**
         * setX
         *
         * @param double $x
         */
        public function setX($x) {
            $this->x = $x;
        }

        /**
         * getY
         *
         * @return double
         */
        public function getY() {
            return $this->y;
        }

        /**
         * setY
         *
         * @param double $y
         */
        public function sety($y) {
            $this->y = $y;
        }

        /**
         * getZ
         *
         * @return double
         */
        public function getz() {
            return $this->z;
        }

        /**
         * setZ
         *
         * @param double $z
         */
        public function setZ($z) {
            $this->z = $z;
        }
    }
}
