<?php

/**
 * Copyright (C) 2017 Rounon Dax
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

/**
 * EVE API Helper
 *
 * Getting some stuff from CCP's EVE API
 */

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

use WordPress\EsiClient\Model\Alliances\AllianceId;
use WordPress\EsiClient\Model\Corporations\CorporationId;
use WordPress\EsiClient\Model\Sovereignty\Map;
use WordPress\EsiClient\Model\Universe\Constellations\ConstellationId;
use WordPress\EsiClient\Model\Universe\Groups\GroupId;
use WordPress\EsiClient\Model\Universe\Ids;
use WordPress\EsiClient\Model\Universe\Regions\RegionId;
use WordPress\EsiClient\Model\Universe\Systems\SystemId;
use WordPress\EsiClient\Model\Universe\Types\TypeId;
use WordPress\EsiClient\Repository\AllianceRepository;
use WordPress\EsiClient\Repository\CharacterRepository;
use WordPress\EsiClient\Repository\CorporationRepository;
use WordPress\EsiClient\Repository\MetaRepository;
use WordPress\EsiClient\Repository\SovereigntyRepository;
use WordPress\EsiClient\Repository\UniverseRepository;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

class EsiHelper extends AbstractSingleton {
    /**
     * Database Helper
     *
     * @var DatabaseHelper
     */
    private $databaseHelper = null;

    /**
     * ESI Character API
     *
     * @var CharacterRepository
     */
    private $characterApi = null;

    /**
     * ESI Corporation API
     *
     * @var CorporationRepository
     */
    private $corporationApi = null;

    /**
     * ESI Alliance API
     *
     * @var AllianceRepository
     */
    private $allianceApi = null;

    /**
     * ESI Universe API
     *
     * @var UniverseRepository
     */
    private $universeApi = null;

    /**
     * ESI Sovereignty Repository
     *
     * @var SovereigntyRepository
     */
    private $sovereigntyApi = null;

    /**
     * ESI Meta
     *
     * @var MetaRepository
     */
    private $metaApi = null;

    /**
     * The Constructor
     */
    protected function __construct() {
        parent::__construct();

        $this->databaseHelper = DatabaseHelper::getInstance();

        /**
         * ESI API Client
         */
        $this->characterApi = new CharacterRepository;
        $this->corporationApi = new CorporationRepository;
        $this->allianceApi = new AllianceRepository;
        $this->universeApi = new UniverseRepository;
        $this->sovereigntyApi = new SovereigntyRepository;
        $this->metaApi = new MetaRepository;
    }

    /**
     * Getting all the needed ship information from the ESI
     *
     * @param int $shipId
     * @return array|null
     */
    public function getShipData(int $shipId): ?array {
        $returnData = null;

        /* @var $shipClassData TypeId */
        $shipClassData = $this->getShipClassDataFromShipId(shipId: $shipId);

        $shipTypeData = null;

        if (is_a($shipClassData, class: '\WordPress\EsiClient\Model\Universe\Types\TypeId') && !is_null(value: $shipClassData->getGroupId())) {
            /* @var $shipTypeData GroupId */
            $shipTypeData = $this->getShipTypeDataFromShipClass($shipClassData);
        }

        if (is_a(object_or_class: $shipClassData, class: '\WordPress\EsiClient\Model\Universe\Types\TypeId') && is_a(object_or_class: $shipTypeData, class: '\WordPress\EsiClient\Model\Universe\Groups\GroupId')) {
            $returnData = [
                'shipData' => $shipClassData,
                'shipTypeData' => $shipTypeData
            ];
        }

        return $returnData;
    }

    /**
     * Getting ship class data by ship id
     *
     * @param int $shipId
     * @return TypeId
     */
    public function getShipClassDataFromShipId(int $shipId): TypeId {
        /* @var $shipClassData TypeId */
        $shipClassData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/types/' . $shipId);

        if (is_null($shipClassData)) {
            $shipClassData = $this->universeApi->universeTypesTypeId(typeId: $shipId);

            if (is_a($shipClassData, class: '\WordPress\EsiClient\Model\Universe\Types\TypeId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/types/' . $shipId,
                    maybe_serialize(data: $shipClassData),
                    strtotime(datetime: '+1 week')
                ]);
            }
        }

        return $shipClassData;
    }

    /**
     * Get ship type data by ship class
     *
     * @param TypeId $shipData
     * @return GroupId
     */
    public function getShipTypeDataFromShipClass(TypeId $shipData): GroupId {
        /* @var $shipTypeData GroupId */
        $shipTypeData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/groups/' . $shipData->getGroupId());

        if (is_null($shipTypeData)) {
            $shipTypeData = $this->universeApi->universeGroupsGroupId(groupId: $shipData->getGroupId());

            if (is_a(object_or_class: $shipTypeData, class: '\WordPress\EsiClient\Model\Universe\Groups\GroupId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/groups/' . $shipData->getGroupId(),
                    maybe_serialize(data: $shipTypeData),
                    strtotime(datetime: '+1 week')
                ]);
            }
        }

        return $shipTypeData;
    }

    /**
     * Get the affiliation for a set of characterIDs
     *
     * @param array $characterIds
     * @return array|null
     */
    public function getCharacterAffiliation(array $characterIds): ?array {
        return $this->characterApi->charactersAffiliation(characterIds: array_values(array: $characterIds));
    }

    /**
     * Get the IDs to an array of names
     *
     * @param array $names
     * @param string $type
     * @return array|null
     */
    public function getIdFromName(array $names, string $type): ?array {
        $returnData = null;

        /* @var $esiData Ids */
        $esiData = $this->universeApi->universeIds(names: array_values(array: $names));

        if (is_a(object_or_class: $esiData, class: '\WordPress\EsiClient\Model\Universe\Ids')) {
            switch ($type) {
                case 'agents':
                    $returnData = $esiData->getAgents();
                    break;

                case 'alliances':
                    $returnData = $esiData->getAlliances();
                    break;

                case 'constellations':
                    $returnData = $esiData->getConstellations();
                    break;

                case 'characters':
                    $returnData = $esiData->getCharacters();
                    break;

                case 'corporations':
                    $returnData = $esiData->getCorporations();
                    break;

                case 'factions':
                    $returnData = $esiData->getFactions();
                    break;

                case 'inventoryTypes':
                    $returnData = $esiData->getInventoryTypes();
                    break;

                case 'regions':
                    $returnData = $esiData->getRegions();
                    break;

                case 'stations':
                    $returnData = $esiData->getStations();
                    break;

                case 'systems':
                    $returnData = $esiData->getSystems();
                    break;
            }
        }

        return $returnData;
    }

    /**
     * Get corporation data by ID
     *
     * @param int $corporationId
     * @return CorporationId
     */
    public function getCorporationData(int $corporationId): CorporationId {
        $corporationData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'corporations/' . $corporationId);

        if (is_null(value: $corporationData)) {
            $corporationData = $this->corporationApi->corporationsCorporationId(corporationID: $corporationId);

            if (is_a(object_or_class: $corporationData, class: '\WordPress\EsiClient\Model\Corporations\CorporationId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'corporations/' . $corporationId,
                    maybe_serialize(data: $corporationData),
                    strtotime(datetime: '+1 week')
                ]);
            }
        }

        return $corporationData;
    }

    /**
     * Get alliance data by ID
     *
     * @param int $allianceId
     * @return AllianceId
     */
    public function getAllianceData(int $allianceId): AllianceId {
        $allianceData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'alliances/' . $allianceId);

        if (is_null(value: $allianceData)) {
            $allianceData = $this->allianceApi->alliancesAllianceId($allianceId);

            if (is_a(object_or_class: $allianceData, class: '\WordPress\EsiClient\Model\Alliances\AllianceId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'alliances/' . $allianceId,
                    maybe_serialize(data: $allianceData),
                    strtotime(datetime: '+1 week')
                ]);
            }
        }

        return $allianceData;
    }

    /**
     * Getting all the needed system information from the ESI
     *
     * @param int $systemId
     * @return SystemId
     */
    public function getSystemData(int $systemId): SystemId {
        $systemData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/systems/' . $systemId);

        if (is_null(value: $systemData)) {
            $systemData = $this->universeApi->universeSystemsSystemId(systemId: $systemId);

            if (is_a(object_or_class: $systemData, class: '\WordPress\EsiClient\Model\Universe\Systems\SystemId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/systems/' . $systemId,
                    maybe_serialize(data: $systemData),
                    strtotime(datetime: '+10 years')
                ]);
            }
        }

        return $systemData;
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $constellationId
     * @return ConstellationId
     */
    public function getConstellationData(int $constellationId): ConstellationId {
        $constellationData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/constellations/' . $constellationId);

        if (is_null(value: $constellationData)) {
            $constellationData = $this->universeApi->universeConstellationsConstellationId(constellationId: $constellationId);

            if (is_a(object_or_class: $constellationData, class: '\WordPress\EsiClient\Model\Universe\Constellations\ConstellationId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/constellations/' . $constellationId,
                    maybe_serialize(data: $constellationData),
                    strtotime(datetime: '+10 years')
                ]);
            }
        }

        return $constellationData;
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $regionId
     * @return RegionId
     */
    public function getRegionsRegionId(int $regionId): RegionId {
        $regionData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/regions/' . $regionId);

        if (is_null(value: $regionData)) {
            $regionData = $this->universeApi->universeRegionsRegionId(regionId: $regionId);

            if (is_a(object_or_class: $regionData, class: '\WordPress\EsiClient\Model\Universe\Regions\RegionId')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/regions/' . $regionId,
                    maybe_serialize(data: $regionData),
                    strtotime(datetime: '+10 years')
                ]);
            }
        }

        return $regionData;
    }

    /**
     * Get the number of jumps in solar systems within the last hour ending
     * at the timestamp of the Last-Modified header, excluding wormhole space.
     * Only systems with jumps will be listed
     *
     * @return array
     */
    public function getSystemJumps(): ?array {
        $systemJumpsData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/system_jumps');

        if (is_null(value: $systemJumpsData)) {
            $systemJumpsData = $this->universeApi->universeSystemJumps();

            if (is_array(value: $systemJumpsData)) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/system_jumps',
                    maybe_serialize(data: $systemJumpsData),
                    strtotime(datetime: '+1 hour')
                ]);
            }
        }

        return $systemJumpsData;
    }

    /**
     * Get the number of ship, pod and NPC kills per solar system within
     * the last hour ending at the timestamp of the Last-Modified header,
     * excluding wormhole space. Only systems with kills will be listed
     *
     * @return array
     */
    public function getSystemKills(): ?array {
        $systemKillsData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'universe/system_kills');

        if (is_null(value: $systemKillsData)) {
            $systemKillsData = $this->universeApi->universeSystemKills();

            if (is_array(value: $systemKillsData)) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'universe/system_kills',
                    maybe_serialize(data: $systemKillsData),
                    strtotime(datetime: '+1 hour')
                ]);
            }
        }

        return $systemKillsData;
    }

    /**
     * get sov map
     *
     * @return array
     */
    public function getSovereigntyMap(): Map {
        $sovereigntyCampaignData = $this->databaseHelper->getCachedEsiDataFromDb(route: 'sovereignty/map');

        if (is_null(value: $sovereigntyCampaignData)) {
            $sovereigntyCampaignData = $this->sovereigntyApi->sovereigntyMap();

            if (is_a(object_or_class: $sovereigntyCampaignData, class: '\WordPress\EsiClient\Model\Sovereignty\Map')) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'sovereignty/map',
                    maybe_serialize(data: $sovereigntyCampaignData),
                    strtotime(datetime: '+1 hour')
                ]);
            }
        }

        return $sovereigntyCampaignData;
    }

    public function getSovereigntyStryuctures(): ?array {
        $sovereigntyCampaignData = $this->databaseHelper->getCachedEsiDataFromDb('sovereignty/structures');

        if (is_null($sovereigntyCampaignData)) {
            $sovereigntyCampaignData = $this->sovereigntyApi->sovereigntyStructures();

            if (!is_null($sovereigntyCampaignData) && is_array($sovereigntyCampaignData)) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'sovereignty/structures',
                    maybe_serialize($sovereigntyCampaignData),
                    strtotime('+2 minutes')
                ]);
            }
        }

        return $sovereigntyCampaignData;
    }

    public function getEsiStatusLatest(): ?array {
        $esiStatus = $this->databaseHelper->getCachedEsiDataFromDb(route: 'esi/status/latest');

        if (is_null(value: $esiStatus)) {
            $esiStatus = $this->metaApi->statusJsonLatest();

            if (is_array(value: $esiStatus)) {
                $this->databaseHelper->writeEsiCacheDataToDb(data: [
                    'esi/status/latest',
                    maybe_serialize(data: $esiStatus),
                    strtotime(datetime: '+1 minute')
                ]);
            }
        }

        return $esiStatus;
    }
}
