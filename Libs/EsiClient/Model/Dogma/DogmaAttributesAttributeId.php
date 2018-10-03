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

namespace WordPress\EsiClient\Model\Dogma;

class DogmaAttributesAttributeId {
    /**
     * attributeId
     *
     * @var int
     */
    protected $attributeId = null;

    /**
     * defaultValue
     *
     * @var float
     */
    protected $defaultValue = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = null;

    /**
     * displayName
     *
     * @var string
     */
    protected $displayName = null;

    /**
     * highIsGood
     *
     * @var boolean
     */
    protected $highIsGood = null;

    /**
     * iconId
     *
     * @var int
     */
    protected $iconId = null;

    /**
     * name
     *
     * @var string
     */
    protected $name = null;

    /**
     * published
     *
     * @var boolean
     */
    protected $published = null;

    /**
     * stackable
     *
     * @var boolean
     */
    protected $stackable = null;

    /**
     * unitId
     *
     * @var int
     */
    protected $unitId = null;

    /**
     * getAttributeId
     *
     * @return int
     */
    public function getAttributeId() {
        return $this->attributeId;
    }

    /**
     * setAttributeId
     *
     * @param int $attributeId
     */
    public function setAttributeId($attributeId) {
        $this->attributeId = $attributeId;
    }

    /**
     * getDefaultValue
     *
     * @return float
     */
    public function getDefaultValue() {
        return $this->defaultValue;
    }

    /**
     * setDefaultValue
     *
     * @param float $defaultValue
     */
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
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
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * getDisplayName
     *
     * @return string
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * setDisplayName
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName) {
        $this->displayName = $displayName;
    }

    /**
     * getHighIsGood
     *
     * @return boolean
     */
    public function getHighIsGood() {
        return $this->highIsGood;
    }

    /**
     * setHighIsGood
     *
     * @param boolean $highIsGood
     */
    public function setHighIsGood($highIsGood) {
        $this->highIsGood = $highIsGood;
    }

    /**
     * getIconId
     *
     * @return int
     */
    public function getIconId() {
        return $this->iconId;
    }

    /**
     * setIconId
     *
     * @param int $iconId
     */
    public function setIconId($iconId) {
        $this->iconId = $iconId;
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
     * getPublished
     *
     * @return boolean
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * setPublished
     *
     * @param boolean $published
     */
    public function setPublished($published) {
        $this->published = $published;
    }

    /**
     * getStackable
     *
     * @return boolean
     */
    public function getStackable() {
        return $this->stackable;
    }

    /**
     * setStackable
     *
     * @param boolean $stackable
     */
    public function setStackable($stackable) {
        $this->stackable = $stackable;
    }

    /**
     * getUnitId
     *
     * @return int
     */
    public function getUnitId() {
        return $this->unitId;
    }

    /**
     * setUnitId
     *
     * @param int $unitId
     */
    public function setUnitId($unitId) {
        $this->unitId = $unitId;
    }
}
