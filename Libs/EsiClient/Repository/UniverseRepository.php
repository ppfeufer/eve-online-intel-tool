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

namespace WordPress\EsiClient\Repository;

\defined('ABSPATH') or die();

if(!\class_exists('\WordPress\EsiClient\Repository\UniverseRepository')) {
    class UniverseRepository extends \WordPress\EsiClient\Swagger {
        /**
         * Used ESI enpoints in this class
         *
         * @var array ESI enpoints
         */
        protected $esiEndpoints = [
            'universe_ancestries' => 'universe/ancestries/?datasource=tranquility',
            'universe_asteroidBelts_asteroidBeltId' => 'universe/asteroid_belts/{asteroid_belt_id}/?datasource=tranquility',
            'universe_bloodlines' => 'universe/bloodlines/?datasource=tranquility',
            'universe_categories' => 'universe/categories/?datasource=tranquility',
            'universe_categories_categoryId' => 'universe/categories/{category_id}/?datasource=tranquility',
            'universe_constellations' => 'universe/constellations/?datasource=tranquility',
            'universe_constellations_constellationId' => 'universe/constellations/{constellation_id}/?datasource=tranquility',
            'universe_factions' => 'universe/factions/?datasource=tranquility',
            'universe_graphics' => 'universe/graphics/?datasource=tranquility',
            'universe_graphics_graphicId' => 'universe/graphics/{graphic_id}/?datasource=tranquility',
            'universe_groups' => 'universe/groups/?datasource=tranquility',
            'universe_groups_groupId' => 'universe/groups/{group_id}/?datasource=tranquility',
            'universe_ids' => 'universe/ids/?datasource=tranquility',
            'universe_moons_moonId' => 'universe/moons/{moon_id}/?datasource=tranquility',
            'universe_names' => 'universe/names/?datasource=tranquility',
            'universe_planets_planetId' => 'universe/planets/{planet_id}/?datasource=tranquility',
            'universe_races' => 'universe/races/?datasource=tranquility',
            'universe_regions' => 'universe/regions/?datasource=tranquility',
            'universe_regions_regionId' => 'universe/regions/{region_id}/?datasource=tranquility',
            'universe_stargates_stargateId' => 'universe/stargates/{stargate_id}/?datasource=tranquility',
            'universe_stars_starId' => 'universe/stars/{star_id}/?datasource=tranquility',
            'universe_stations_stationId' => 'universe/stations/{station_id}/?datasource=tranquility',
            'universe_structures' => 'universe/structures/?datasource=tranquility',
            'universe_systemJumps' => 'universe/system_jumps/?datasource=tranquility',
            'universe_systemKills' => 'universe/system_kills/?datasource=tranquility',
            'universe_systems' => 'universe/systems/?datasource=tranquility',
            'universe_systems_systemId' => 'universe/systems/{system_id}/?datasource=tranquility',
            'universe_types' => 'universe/types/?datasource=tranquility',
            'universe_types_typeId' => 'universe/types/{type_id}/?datasource=tranquility',
        ];

        /**
         * Get all character ancestries
         *
         * @return array of \WordPress\EsiClient\Model\Universe\UniverseAncestries
         */
        public function universeAncestries() {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_ancestries']);
            $this->setEsiVersion('v1');

            return $this->mapArray($this->callEsi(), '\\WordPress\EsiClient\Model\Universe\UniverseAncestries');
        }

        /**
         * Get information on an asteroid belt
         *
         * @param int $asteroidBeltId
         * @return \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId
         */
        public function universeAsteroidBeltsAsteroidBeltId($asteroidBeltId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_asteroidBelts_asteroidBeltId']);
            $this->setEsiRouteParameter([
                '/{asteroid_belt_id}/' => $asteroidBeltId
            ]);
            $this->setEsiVersion('v1');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId);
        }

        /**
         * Get information on a constellation
         *
         * @param int $constellationId An EVE constellation ID
         * @return \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId
         */
        public function universeConstellationsConstellationId($constellationId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_constellations_constellationId']);
            $this->setEsiRouteParameter([
                '/{constellation_id}/' => $constellationId
            ]);
            $this->setEsiVersion('v1');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseConstellationsConstellationId);
        }

        /**
         * Get information on an item group
         *
         * @param int $groupId An Eve item group ID
         * @return \WordPress\EsiClient\Model\Universe\UniverseGroupsGroupId
         */
        public function universeGroupsGroupId($groupId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_groups_groupId']);
            $this->setEsiRouteParameter([
                '/{group_id}/' => $groupId
            ]);
            $this->setEsiVersion('v1');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseGroupsGroupId);
        }

        /**
         * Resolve a set of names to IDs in the following categories:
         * agents, alliances, characters, constellations, corporations factions,
         * inventory_types, regions, stations, and systems.
         *
         * Only exact matches will be returned.
         * All names searched for are cached for 12 hours
         *
         * @param array $names The names to resolve
         * @return \WordPress\EsiClient\Model\Universe\UniverseIds
         */
        public function universeIds(array $names) {
            $this->setEsiMethod('post');
            $this->setEsiPostParameter($names);
            $this->setEsiRoute($this->esiEndpoints['universe_ids']);
            $this->setEsiVersion('v1');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseIds);
        }

        /**
         * Get information on a region
         *
         * @param int $regionId An EVE region ID
         * @return \WordPress\EsiClient\Model\Universe\UniverseRegionsRegionId
         */
        public function universeRegionsRegionId($regionId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_regions_regionId']);
            $this->setEsiRouteParameter([
                '/{region_id}/' => $regionId
            ]);
            $this->setEsiVersion('v1');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseRegionsRegionId);
        }

        /**
         * Get the number of jumps in solar systems within the last hour
         * ending at the timestamp of the Last-Modified header, excluding
         * wormhole space. Only systems with jumps will be listed
         *
         * @return array
         */
        public function universeSystemJumps() {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_systemJumps']);
            $this->setEsiVersion('v1');

            return $this->mapArray($this->callEsi(), '\\WordPress\EsiClient\Model\Universe\UniverseSystemJumps');
        }

        /**
         * Get the number of ship, pod and NPC kills per solar system within
         * the last hour ending at the timestamp of the Last-Modified header,
         * excluding wormhole space. Only systems with kills will be listed
         *
         * @return array
         */
        public function universeSystemKills() {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_systemKills']);
            $this->setEsiVersion('v2');

            return $this->mapArray($this->callEsi(), '\\WordPress\EsiClient\Model\Universe\UniverseSystemKills');
        }

        /**
         * Get information on a solar system
         *
         * @param int $systemId An EVE solar system ID
         * @return \WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId
         */
        public function universeSystemsSystemId($systemId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_systems_systemId']);
            $this->setEsiRouteParameter([
                '/{system_id}/' => $systemId
            ]);
            $this->setEsiVersion('v4');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseSystemsSystemId);
        }

        /**
         * Get information on a type
         *
         * @param int $typeId An Eve item type ID
         * @return \WordPress\EsiClient\Model\Universe\UniverseTypesTypeId
         */
        public function universeTypesTypeId($typeId) {
            $this->setEsiMethod('get');
            $this->setEsiRoute($this->esiEndpoints['universe_types_typeId']);
            $this->setEsiRouteParameter([
                '/{type_id}/' => $typeId
            ]);
            $this->setEsiVersion('v3');

            return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Universe\UniverseTypesTypeId);
        }
    }
}
