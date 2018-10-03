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

class UniverseSystemsSystemId {
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
     * planets
     *
     * @var array
     */
    protected $planets = null;

    /**
     * position
     *
     * @var \WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Position
     */
    protected $position = null;

    /**
     * securityClass
     *
     * @var string
     */
    protected $securityClass = null;

    /**
     * securityStatus
     *
     * @var float
     */
    protected $securityStatus = null;

    /**
     * starId
     *
     * @var int
     */
    protected $starId = null;

    /**
     * stargates
     *
     * @var array
     */
    protected $stargates = null;

    /**
     * stations
     *
     * @var array
     */
    protected $stations = null;

    /**
     * systemId
     *
     * @var int
     */
    protected $systemId = null;

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
     * getPlanets
     *
     * @return array
     */
    public function getPlanets() {
        return $this->planets;
    }

    /**
     * setPlanets
     *
     * @param array $planets
     */
    public function setPlanets(array $planets) {
        $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

        $this->planets = $mapper->mapArray($planets, [], '\\WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Planets');
    }

    /**
     * getPosition
     *
     * @return \WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Position
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * setPosition
     *
     * @param \WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Position $position
     */
    public function setPosition(\WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId\Position $position) {
        $this->position = $position;
    }

    /**
     * getSecurityClass
     *
     * @return string
     */
    public function getSecurityClass() {
        return $this->securityClass;
    }

    /**
     * setSecurityClass
     *
     * @param string $securityClass
     */
    public function setSecurityClass($securityClass) {
        $this->securityClass = $securityClass;
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
    public function setSecurityStatus($securityStatus) {
        $this->securityStatus = $securityStatus;
    }

    /**
     * getStarId
     *
     * @return int
     */
    public function getStarId() {
        return $this->starId;
    }

    /**
     * setStarId
     *
     * @param int $starId
     */
    public function setStarId($starId) {
        $this->starId = $starId;
    }

    /**
     * getStargates
     *
     * @return array
     */
    public function getStargates() {
        return $this->stargates;
    }

    /**
     * setStargates
     *
     * @param array $stargates
     */
    public function setStargates(array $stargates) {
        $this->stargates = $stargates;
    }

    /**
     * getStations
     *
     * @return array
     */
    public function getStations() {
        return $this->stations;
    }

    /**
     * setStations
     *
     * @param array $stations
     */
    public function setStations(array $stations) {
        $this->stations = $stations;
    }

    /**
     * getSystemId
     *
     * @return int
     */
    public function getSystemId() {
        return $this->systemId;
    }

    /**
     * setSystemId
     *
     * @param int $systemId
     */
    public function setSystemId($systemId) {
        $this->systemId = $systemId;
    }
}
