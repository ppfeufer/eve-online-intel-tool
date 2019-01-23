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

use \WordPress\ {
    EsiClient\Model\Alliance\AlliancesAllianceId,
    EsiClient\Model\Alliance\AlliancesAllianceIdIcons,
    EsiClient\Model\Character\CharactersAffiliation,
    EsiClient\Model\Corporation\CorporationsCorporationId,
    EsiClient\Model\Corporation\CorporationsCorporationIdIcons,
    EsiClient\Model\Universe\UniverseConstellationsConstellationId,
    EsiClient\Model\Universe\UniverseGroupsGroupId,
    EsiClient\Model\Universe\UniverseIds,
    EsiClient\Model\Universe\UniverseRegionsRegionId,
    EsiClient\Model\Universe\UniverseSystemJumps,
    EsiClient\Model\Universe\UniverseSystemKills,
    EsiClient\Model\Universe\UniverseSystemsSystemId,
    EsiClient\Model\Universe\UniverseTypesTypeId,
    EsiClient\Repository\AllianceRepository,
    EsiClient\Repository\CharacterRepository,
    EsiClient\Repository\CorporationRepository,
    EsiClient\Repository\MetaRepository,
    EsiClient\Repository\SovereigntyRepository,
    EsiClient\Repository\UniverseRepository,
    Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
};

\defined('ABSPATH') or die();

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
     * @return array
     */
    public function getShipData(int $shipId) {
        $returnData = null;

        /* @var $shipClassData UniverseTypesTypeId */
        $shipClassData = $this->getShipClassDataFromShipId($shipId);

        $shipTypeData = null;

        if(\is_a($shipClassData, '\WordPress\EsiClient\Model\Universe\UniverseTypesTypeId') && !\is_null($shipClassData->getGroupId())) {
            /* @var $shipTypeData UniverseGroupsGroupId */
            $shipTypeData = $this->getShipTypeDataFromShipClass($shipClassData);
        }

        if(\is_a($shipClassData, '\WordPress\EsiClient\Model\Universe\UniverseTypesTypeId') && \is_a($shipTypeData, '\WordPress\EsiClient\Model\Universe\UniverseGroupsGroupId')) {
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
     * @return UniverseTypesTypeId
     */
    public function getShipClassDataFromShipId(int $shipId) {
        /* @var $shipClassData UniverseTypesTypeId */
        $shipClassData = $this->databaseHelper->getCachedEsiDataFromDb('universe/types/' . $shipId);

        if(\is_null($shipClassData)) {
            $shipClassData = $this->universeApi->universeTypesTypeId($shipId);

            if(\is_a($shipClassData, '\WordPress\EsiClient\Model\Universe\UniverseTypesTypeId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/types/' . $shipId,
                    \maybe_serialize($shipClassData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $shipClassData;
    }

    /**
     * Get ship type data by ship class
     *
     * @param UniverseTypesTypeId $shipData
     * @return UniverseGroupsGroupId
     */
    public function getShipTypeDataFromShipClass(UniverseTypesTypeId $shipData) {
        /* @var $shipTypeData UniverseGroupsGroupId */
        $shipTypeData = $this->databaseHelper->getCachedEsiDataFromDb('universe/groups/' . $shipData->getGroupId());

        if(\is_null($shipTypeData)) {
            $shipTypeData = $this->universeApi->universeGroupsGroupId($shipData->getGroupId());

            if(\is_a($shipTypeData, '\WordPress\EsiClient\Model\Universe\UniverseGroupsGroupId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/groups/' . $shipData->getGroupId(),
                    \maybe_serialize($shipTypeData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $shipTypeData;
    }

    /**
     * Get the affiliation for a set of characterIDs
     *
     * @param array $characterIds
     * @return CharactersAffiliation
     */
    public function getCharacterAffiliation(array $characterIds) {
        $characterAffiliationData = $this->characterApi->charactersAffiliation(\array_values($characterIds));

        return $characterAffiliationData;
    }

    /**
     * Get the IDs to an array of names
     *
     * @param array $names
     * @param string $type
     * @return type
     */
    public function getIdFromName(array $names, string $type) {
        $returnData = null;

        /* @var $esiData UniverseIds */
        $esiData = $this->universeApi->universeIds(\array_values($names));

        if(\is_a($esiData, '\WordPress\EsiClient\Model\Universe\UniverseIds')) {
            switch($type) {
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
     * @return CorporationsCorporationId
     */
    public function getCorporationData(int $corporationId) {
        $corporationData = $this->databaseHelper->getCachedEsiDataFromDb('corporations/' . $corporationId);

        if(\is_null($corporationData)) {
            $corporationData = $this->corporationApi->corporationsCorporationId($corporationId);

            if(\is_a($corporationData, '\WordPress\EsiClient\Model\Corporation\CorporationsCorporationId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'corporations/' . $corporationId,
                    \maybe_serialize($corporationData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $corporationData;
    }

    /**
     * Get alliance data by ID
     *
     * @param int $allianceId
     * @return AlliancesAllianceId
     */
    public function getAllianceData(int $allianceId) {
        $allianceData = $this->databaseHelper->getCachedEsiDataFromDb('alliances/' . $allianceId);

        if(\is_null($allianceData)) {
            $allianceData = $this->allianceApi->alliancesAllianceId($allianceId);

            if(\is_a($allianceData, '\WordPress\EsiClient\Model\Alliance\AlliancesAllianceId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'alliances/' . $allianceId,
                    \maybe_serialize($allianceData),
                    \strtotime('+1 week')
                ]);
            }
        }

        return $allianceData;
    }

    /**
     * Getting all the needed system information from the ESI
     *
     * @param int $systemId
     * @return UniverseSystemsSystemId
     */
    public function getSystemData(int $systemId) {
        $systemData = $this->databaseHelper->getCachedEsiDataFromDb('universe/systems/' . $systemId);

        if(\is_null($systemData)) {
            $systemData = $this->universeApi->universeSystemsSystemId($systemId);

            if(\is_a($systemData, '\WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/systems/' . $systemId,
                    \maybe_serialize($systemData),
                    \strtotime('+10 years')
                ]);
            }
        }

        return $systemData;
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $constellationId
     * @return UniverseConstellationsConstellationId
     */
    public function getConstellationData(int $constellationId) {
        $constellationData = $this->databaseHelper->getCachedEsiDataFromDb('universe/constellations/' . $constellationId);

        if(\is_null($constellationData)) {
            $constellationData = $this->universeApi->universeConstellationsConstellationId($constellationId);

            if(\is_a($constellationData, '\WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/constellations/' . $constellationId,
                    \maybe_serialize($constellationData),
                    \strtotime('+10 years')
                ]);
            }
        }

        return $constellationData;
    }

    /**
     * Getting all the needed constellation information from the ESI
     *
     * @param int $regionId
     * @return UniverseRegionsRegionId
     */
    public function getRegionsRegionId(int $regionId) {
        $regionData = $this->databaseHelper->getCachedEsiDataFromDb('universe/regions/' . $regionId);

        if(\is_null($regionData)) {
            $regionData = $this->universeApi->universeRegionsRegionId($regionId);

            if(\is_a($regionData, '\WordPress\EsiClient\Model\Universe\UniverseRegionsRegionId')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/regions/' . $regionId,
                    \maybe_serialize($regionData),
                    \strtotime('+10 years')
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
     * @return UniverseSystemJumps
     */
    public function getSystemJumps() {
        $systemJumpsData = $this->databaseHelper->getCachedEsiDataFromDb('universe/system_jumps');

        if(\is_null($systemJumpsData)) {
            $systemJumpsData = $this->universeApi->universeSystemJumps();

            if(!\is_null($systemJumpsData) && \is_array($systemJumpsData)) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/system_jumps',
                    \maybe_serialize($systemJumpsData),
                    \strtotime('+1 hour')
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
     * @return UniverseSystemKills
     */
    public function getSystemKills() {
        $systemKillsData = $this->databaseHelper->getCachedEsiDataFromDb('universe/system_kills');

        if(\is_null($systemKillsData)) {
            $systemKillsData = $this->universeApi->universeSystemKills();

            if(!\is_null($systemKillsData) && \is_array($systemKillsData)) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'universe/system_kills',
                    \maybe_serialize($systemKillsData),
                    \strtotime('+1 hour')
                ]);
            }
        }

        return $systemKillsData;
    }

    public function getSovereigntyMap() {
        $sovereigntyCampaignData = $this->databaseHelper->getCachedEsiDataFromDb('sovereignty/map');

        if(\is_null($sovereigntyCampaignData)) {
            $sovereigntyCampaignData = $this->sovereigntyApi->sovereigntyMap();

            if(\is_a($sovereigntyCampaignData, '\WordPress\EsiClient\Model\Sovereignty\SovereigntyMap')) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'sovereignty/map',
                    \maybe_serialize($sovereigntyCampaignData),
                    \strtotime('+1 hour')
                ]);
            }
        }

        return $sovereigntyCampaignData;
    }

    public function getSovereigntyStryuctures() {
        $sovereigntyCampaignData = $this->databaseHelper->getCachedEsiDataFromDb('sovereignty/structures');

        if(\is_null($sovereigntyCampaignData)) {
            $sovereigntyCampaignData = $this->sovereigntyApi->sovereigntyStructures();

            if(!\is_null($sovereigntyCampaignData) && \is_array($sovereigntyCampaignData)) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'sovereignty/structures',
                    \maybe_serialize($sovereigntyCampaignData),
                    \strtotime('+2 minutes')
                ]);
            }
        }

        return $sovereigntyCampaignData;
    }

    public function getEsiStatusLatest() {
        $esiStatus = $this->databaseHelper->getCachedEsiDataFromDb('esi/status/latest');

        if(\is_null($esiStatus)) {
            $esiStatus = $this->metaApi->statusJsonLatest();

            if(!\is_null($esiStatus) && \is_array($esiStatus)) {
                $this->databaseHelper->writeEsiCacheDataToDb([
                    'esi/status/latest',
                    \maybe_serialize($esiStatus),
                    \strtotime('+1 minute')
                ]);
            }
        }

        return $esiStatus;
    }
}
