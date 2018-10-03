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

class UniverseConstellationsConstellationId {
    /**
     * constellationId
     *
     * The constellation this solar system is in
     *
     * @var int
     */
    protected $constellationId = null;

    /**
     * name
     *
     * @var string
     */
    protected $name = null;

    /**
     * position
     *
     * @var \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId\Position
     */
    protected $position = null;

    /**
     * regionId
     *
     * @var int
     */
    protected $regionId = null;

    /**
     * systems
     *
     * @var array
     */
    protected $systems = null;

    /**
     * getConstellationId
     *
     * @return int
     */
    public function getConstellationId() {
        return $this->constellationId;
    }

    /**
     * setConstellationId
     *
     * @param int $constellationId
     */
    public function setConstellationId($constellationId) {
        $this->constellationId = $constellationId;
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
     * getPosition
     *
     * @return \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId\Position
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * setPosition
     *
     * @param \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId\Position $position
     */
    public function setPosition(\WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId\Position $position) {
        $this->position = $position;
    }

    /**
     * getRegionId
     *
     * @return int
     */
    public function getRegionId() {
        return $this->regionId;
    }

    /**
     * setRegionId
     *
     * @param int $regionId
     */
    public function setRegionId($regionId) {
        $this->regionId = $regionId;
    }

    /**
     * getSystems
     *
     * @return array
     */
    public function getSystems() {
        return $this->systems;
    }

    /**
     * setSystems
     *
     * @param array $systems
     */
    public function setSystems(array $systems) {
        $this->systems = $systems;
    }
}
