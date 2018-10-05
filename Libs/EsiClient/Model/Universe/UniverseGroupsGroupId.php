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

if(!\class_exists('\WordPress\EsiClient\Model\Universe\UniverseGroupsGroupId')) {
    class UniverseGroupsGroupId {
        /**
         * categoryId
         *
         * @var int
         */
        protected $categoryId = null;

        /**
         * groupId
         *
         * @var int
         */
        protected $groupId = null;

        /**
         * name
         *
         * @var string
         */
        protected $name = null;

        /**
         * published
         *
         * @var bool
         */
        protected $published = null;

        /**
         * types
         *
         * @var array
         */
        protected $types = null;

        /**
         * getCategoryId
         *
         * @return int
         */
        public function getCategoryId() {
            return $this->categoryId;
        }

        /**
         * setCategoryId
         *
         * @param int $categoryId
         */
        public function setCategoryId(int $categoryId) {
            $this->categoryId = $categoryId;
        }

        /**
         * getGroupId
         *
         * @return int
         */
        public function getGroupId() {
            return $this->groupId;
        }

        /**
         * setGroupId
         *
         * @param int $groupId
         */
        public function setGroupId(int $groupId) {
            $this->groupId = $groupId;
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
         * getPublished
         *
         * @return bool
         */
        public function getPublished() {
            return $this->published;
        }

        /**
         * setPublished
         *
         * @param bool $published
         */
        public function setPublished(bool $published) {
            $this->published = $published;
        }

        /**
         * getTypes
         *
         * @return array
         */
        public function getTypes() {
            return $this->types;
        }

        /**
         * setTypes
         *
         * @param array $types
         */
        public function setTypes(array $types) {
            $this->types = $types;
        }
    }
}
