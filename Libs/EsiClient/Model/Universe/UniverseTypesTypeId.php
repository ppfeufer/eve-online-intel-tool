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

class UniverseTypesTypeId {
    /**
     * capacity
     *
     * @var float
     */
    protected $capacity = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = null;

    /**
     * dogmaAttributes
     *
     * @var array
     */
    protected $dogmaAttributes = null;

    /**
     * dogmaEffects
     *
     * @var array
     */
    protected $dogmaEffects = null;

    /**
     * graphicId
     *
     * @var int
     */
    protected $graphicId = null;

    /**
     * groupId
     *
     * @var int
     */
    protected $groupId =  null;

    /**
     * iconId
     *
     * @var int
     */
    protected $iconId = null;

    /**
     * marketGroupId
     *
     * @var int
     */
    protected $marketGroupId = null;

    /**
     * mass
     *
     * @var float
     */
    protected $mass = null;

    /**
     * name
     *
     * @var string
     */
    protected $name = null;

    /**
     * packagedVolume
     *
     * @var float
     */
    protected $packagedVolume = null;

    /**
     * portionSize
     *
     * @var int
     */
    protected $portionSize = null;

    /**
     * published
     *
     * @var boolean
     */
    protected $published = false;

    /**
     * radius
     *
     * @var float
     */
    protected $radius = null;

    /**
     * typeId
     *
     * @var int
     */
    protected $typeId = null;

    /**
     * volume
     *
     * @var float
     */
    protected $volume = null;

    /**
     * getCapacity
     *
     * @return float
     */
    public function getCapacity() {
        return $this->capacity;
    }

    /**
     * setCapacity
     *
     * @param float $capacity
     */
    public function setCapacity($capacity) {
        $this->capacity = $capacity;
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
     * getDogmaAttributes
     *
     * @return array
     */
    public function getDogmaAttributes() {
        return $this->dogmaAttributes;
    }

    /**
     * setDogmaAttributes
     *
     * @param array $dogmaAttributes
     */
    public function setDogmaAttributes(array $dogmaAttributes) {
        $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

        $this->dogmaAttributes = $mapper->mapArray($dogmaAttributes, [], '\\WordPress\EsiClient\Model\Universe\UniverseTypesTypeId\DogmaAttribute');
    }

    /**
     * getDogmaEffects
     *
     * @return array
     */
    public function getDogmaEffects() {
        return $this->dogmaEffects;
    }

    /**
     * setDogmaEffects
     *
     * @param array $dogmaEffects
     */
    public function setDogmaEffects(array $dogmaEffects) {
        $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

        $this->dogmaEffects = $mapper->mapArray($dogmaEffects, [], '\\WordPress\EsiClient\Model\Universe\UniverseTypesTypeId\DogmaEffect');
    }

    /**
     * getGraphicId
     *
     * @return int
     */
    public function getGraphicId() {
        return $this->graphicId;
    }

    /**
     * setGraphicId
     *
     * @param int $graphicId
     */
    public function setGraphicId($graphicId) {
        $this->graphicId = $graphicId;
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
    public function setGroupId($groupId) {
        $this->groupId = $groupId;
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
     * getMarketGroupId
     *
     * @return int
     */
    public function getMarketGroupId() {
        return $this->marketGroupId;
    }

    /**
     * setMarketGroupId
     *
     * @param int $marketGroupId
     */
    public function setMarketGroupId($marketGroupId) {
        $this->marketGroupId = $marketGroupId;
    }

    /**
     * getMass
     *
     * @return float
     */
    public function getMass() {
        return $this->mass;
    }

    /**
     * setMass
     *
     * @param float $mass
     */
    public function setMass($mass) {
        $this->mass = $mass;
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
     * getPackagedVolume
     *
     * @return float
     */
    public function getPackagedVolume() {
        return $this->packagedVolume;
    }

    /**
     * setPackedVolume
     *
     * @param float $packagedVolume
     */
    public function setPackedVolume($packagedVolume) {
        $this->packagedVolume = $packagedVolume;
    }

    /**
     * getPortionSize
     *
     * @return int
     */
    public function getPortionSize() {
        return $this->portionSize;
    }

    /**
     * setPortionSize
     *
     * @param int $portionSize
     */
    public function setPortionSize($portionSize) {
        $this->portionSize = $portionSize;
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
     * getRadius
     *
     * @return float
     */
    public function getRadius() {
        return $this->radius;
    }

    /**
     * setRadius
     *
     * @param float $radius
     */
    public function setRadius($radius) {
        $this->radius = $radius;
    }

    /**
     * getTypeId
     *
     * @return int
     */
    public function getTypeId() {
        return $this->typeId;
    }

    /**
     * setTypeId
     *
     * @param int $typeId
     */
    public function setTypeId($typeId) {
        $this->typeId = $typeId;
    }

    /**
     * getVolume
     *
     * @return float
     */
    public function getVolume() {
        return $this->volume;
    }

    /**
     * setVolume
     *
     * @param float $volume
     */
    public function setVolume($volume) {
        $this->volume = $volume;
    }
}
