<?php
/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

/**
 * EVE API Helper
 *
 * Getting some stuff from CCP's EVE API
 */

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

class EsiHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * ESI URL
	 *
	 * @var string
	 */
	private $esiUrl = null;

	/**
	 * ESI Endpoints
	 *
	 * @var array
	 */
	private $esiEndpoints = null;

	/**
	 * Image Server URL
	 *
	 * @var string
	 */
	private $imageserverUrl = null;

	/**
	 * Image Server Endpoints
	 *
	 * @var array
	 */
	private $imageserverEndpoints = null;

	/**
	 * Plugin Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper
	 */
	public $imageHelper = null;

	/**
	 * Plugin Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper
	 */
	public $pluginHelper = null;

	/**
	 * Plugin Settings
	 *
	 * @var array
	 */
	public $pluginSettings = null;

	/**
	 * The Constructor
	 */
	protected function __construct() {
		parent::__construct();

		if(!$this->pluginHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper) {
			$this->pluginHelper = PluginHelper::getInstance();
			$this->pluginSettings = $this->pluginHelper->getPluginSettings();
		} // if(!$this->pluginHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper)

		if(!$this->imageHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper) {
			$this->imageHelper = ImageHelper::getInstance();
			$this->imageserverEndpoints = $this->imageHelper->getImageserverEndpoints();
			$this->imageserverUrl = $this->imageHelper->getImageServerUrl();
		} // if(!$this->imageHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper)

		$this->esiUrl = $this->getEsiUrl();
		$this->esiEndpoints = $this->getEsiEndpoints();
	} // public function __construct()

	/**
	 * Return the ESI API Url
	 *
	 * @return string
	 */
	public function getEsiUrl() {
		return 'https://esi.tech.ccp.is/latest/';
	}

	/**
	 * Return the ESI API endpoints
	 *
	 * @return array
	 */
	public function getEsiEndpoints() {
		/**
		 * Assigning ESI Endpoints
		 *
		 * @see https://esi.tech.ccp.is/latest/
		 */
		return [
			'alliance-information' => 'alliances/', // getting alliance information by ID - https://esi.tech.ccp.is/latest/alliances/99000102/
			'character-information' => 'characters/', // getting character information by ID - https://esi.tech.ccp.is/latest/characters/90607580/
			'character-affiliation' => 'characters/affiliation/', // getting character information by IDs - https://esi.tech.ccp.is/latest/characters/affiliation/ (POST request)
			'corporation-information' => 'corporations/', // getting corporation information by ID - https://esi.tech.ccp.is/latest/corporations/98000030/
			'search' => 'search/', // Search for entities that match a given sub-string. - https://esi.tech.ccp.is/latest/search/?search=Yulai%20Federation&strict=true&categories=alliance
			'group-information' => 'universe/groups/', // getting types information by ID - https://esi.tech.ccp.is/latest/universe/groups/1305/
			'system-information' => 'universe/systems/', // getting system information by ID - https://esi.tech.ccp.is/latest/universe/systems/30000003/
			'constellation-information' => 'universe/constellations/', // getting constellation information by ID - https://esi.tech.ccp.is/latest/universe/constellations/20000315/
			'region-information' => 'universe/regions/', // getting constellation information by ID - https://esi.tech.ccp.is/latest/universe/regions/10000025/
			'type-information' => 'universe/types/', // getting types information by ID - https://esi.tech.ccp.is/latest/universe/types/670/
		];
	}

	/**
	 * Getting all the needed ship information from the ESI
	 *
	 * @param int $shipID
	 * @return array
	 */
	public function getShipData($shipID) {
		$returnData = null;
		$shipData = null;
		$shipClassData = null;

		$resultDB = DatabaseHelper::getInstance()->getShipDataFromDb($shipID);

		if(!\is_null($resultDB)) {
			$shipData = new \stdClass();
			$shipData->type_id = $resultDB->ship_id;
			$shipData->name = $resultDB->class;

			$shipClassData = new \stdClass();
			$shipClassData->name = $resultDB->type;
			$shipClassData->category_id = (int) $resultDB->category_id;
		} // if(!\is_null($resultDB))

		if(\is_null($resultDB)) {
			$shipData = $this->getEsiData($this->esiEndpoints['type-information'] . $shipID . '/', null);
			$shipClassData = $this->getEsiData($this->esiEndpoints['group-information'] . $shipData->group_id . '/', null);

			if(!\is_null($shipData) && !\is_null($shipClassData)) {
				DatabaseHelper::getInstance()->writeShipDataToDb([
					$shipData->type_id,
					$shipData->name,
					$shipClassData->name,
					$shipClassData->category_id,
					\gmdate('Y-m-d H:i:s', \time())
				]);
			} // if(!\is_null($shipData) && !\is_null($shipClassData))
		} // if(\is_null($resultDB))

		if(!\is_null($shipData) && !\is_null($shipClassData)) {
			$returnData = [
				'data' => [
					'shipData' => $shipData,
					'shipTypeData' => $shipClassData
				]
			];
		} // if(!\is_null($shipData) && !\is_null($shipClassData))

		return $returnData;
	} // public function getShipData($shipID)

	/**
	 * Get the character data for a characterID
	 *
	 * @param string $characterID
	 * @return array
	 */
	public function getCharacterData($characterID) {
		$characterData = DatabaseHelper::getInstance()->getCharacterDataFromDb($characterID);

		if(\is_null($characterData) || empty($characterData->name)) {
			$characterData = $this->getEsiData($this->esiEndpoints['character-information'] . $characterID . '/', null);

			if(!\is_null($characterData)) {
				DatabaseHelper::getInstance()->writeCharacterDataToDb([
					$characterID,
					$characterData->name,
					\gmdate('Y-m-d H:i:s', \time())
				]);
			} // if(!\is_null($characterData))
		} // if(\is_null($characterData))

		return [
			'data' => $characterData
		];
	} // public function getCharacterData($characterID)

	/**
	 * Get the affiliation for a set of characterIDs
	 *
	 * @param array $characterIds
	 * @return array
	 */
	public function getCharacterAffiliation(array $characterIds) {
		$characterAffiliationData = $this->getEsiData($this->esiEndpoints['character-affiliation'], null, \array_values($characterIds), 'post');

		return [
			'data' => $characterAffiliationData
		];
	} // public function getCharacterAffiliation(array $characterIds)

	/**
	 * Get corporation data by ID
	 *
	 * @global object $wpdb
	 * @param string $corporationID
	 * @return object
	 */
	public function getCorporationData($corporationID) {
		$corporationData = DatabaseHelper::getInstance()->getCorporationDataFromDb($corporationID);

		if(\is_null($corporationData) || empty($corporationData->corporation_name)) {
			$corporationData = $this->getEsiData($this->esiEndpoints['corporation-information'] . $corporationID . '/', null);

			if(!\is_null($corporationData)) {
				DatabaseHelper::getInstance()->writeCorporationDataToDb([
					$corporationID,
					$corporationData->corporation_name,
					$corporationData->ticker,
					\gmdate('Y-m-d H:i:s', \time())
				]);
			} // if(!\is_null($corporationData))
		} // if(\is_null($corporationData))

		return [
			'data' => $corporationData
		];
	} // public function getCorporationData($corporationID)

	/**
	 * Get alliance data by ID
	 *
	 * @global object $wpdb
	 * @param string $allianceID
	 * @return object
	 */
	public function getAllianceData($allianceID) {
		$allianceData = DatabaseHelper::getInstance()->getAllianceDataFromDb($allianceID);

		if(\is_null($allianceData) || empty($allianceData->alliance_name)) {
			$allianceData = $this->getEsiData($this->esiEndpoints['alliance-information'] . $allianceID . '/', null);

			if(!\is_null($allianceData)) {
				DatabaseHelper::getInstance()->writeAllianceDataToDb([
					$allianceID,
					$allianceData->alliance_name,
					$allianceData->ticker,
					\gmdate('Y-m-d H:i:s', \time())
				]);
			} // if(!\is_null($allianceData))
		} // if(\is_null($allianceData))

		return [
			'data' => $allianceData
		];
	} // public function getAllianceData($allianceID)

	/**
	 * Getting all the needed system information from the ESI
	 *
	 * @param int $systemID
	 * @return array
	 */
	public function getSystemData($systemID) {
		$systemData = $this->getEsiData($this->esiEndpoints['system-information'] . $systemID . '/', 3600);

		return [
			'data' => $systemData
		];
	} // public function getSystemData($systemID)

	/**
	 * Getting all the needed constellation information from the ESI
	 *
	 * @param int $constellationID
	 * @return array
	 */
	public function getConstellationData($constellationID) {
		$constellationData = $this->getEsiData($this->esiEndpoints['constellation-information'] . $constellationID . '/', 3600);

		return [
			'data' => $constellationData
		];
	} // public function getConstellationData($constellationID)

	/**
	 * Getting all the needed constellation information from the ESI
	 *
	 * @param int $regionID
	 * @return array
	 */
	public function getRegionData($regionID) {
		$regionData = $this->getEsiData($this->esiEndpoints['region-information'] . $regionID . '/', 3600);

		return [
			'data' => $regionData
		];
	} // public function getRegionData($regionID)

	/**
	 * Get the EVE ID by it's name
	 *
	 * @param type $name
	 * @param type $type
	 * @return type
	 */
	public function getEveIdFromName($name, $type) {
		$returnData = null;

		$arrayNotInApi = [
			\sanitize_title('Capsule') => [
				'name' => 'Capsule',
				'id' => 670
			],
			\sanitize_title('Capsule - Genolution \'Auroral\' 197-variant') => [
				'name' => 'Capsule - Genolution \'Auroral\' 197-variant',
				'id' => 33328
			]
		];

		// Check DB first
		switch($type) {
			// Pilot
			case 'character':
				$characterData = DatabaseHelper::getInstance()->getCharacterDataFromDbByName($name);

				if(isset($characterData->character_id)) {
					$returnData = $characterData->character_id;
				} // if(isset($characterData->character_id))
				break;

			// Corporation
			case 'corporation':
				$corporationData = DatabaseHelper::getInstance()->getCorporationDataFromDbByName($name);

				if(isset($corporationData->corporation_id)) {
					$returnData = $corporationData->corporation_id;
				} // if(isset($corporationData->corporation_id))
				break;

			// Alliance
			case 'alliance':
				$allianceData = DatabaseHelper::getInstance()->getAllianceDataFromDbByName($name);

				if(isset($allianceData->alliance_id)) {
					$returnData = $allianceData->alliance_id;
				} // if(isset($allianceData->alliance_id))
				break;

			// Ship
			case 'inventorytype':
				break;

			// System
			case 'solarsystem':
				break;
		} // switch($type)

		// No data in our DB, let's get it from the ESI
		if(\is_null($returnData)) {
			if(isset($arrayNotInApi[\sanitize_title($name)])) {
				$returnData = $arrayNotInApi[\sanitize_title($name)]['id'];
			} else {
				$data = $this->getEsiData($this->esiEndpoints['search'] . '?search=' . \urlencode(\wp_specialchars_decode(\trim($name), \ENT_QUOTES)) . '&strict=true&categories=' . $type, null);

				if(!isset($data->error) && !empty((array) $data) && isset($data->{$type})) {
					/**
					 * -= FIX =-
					 * CCPs strict mode is not really strict, so we have to check manually ....
					 * Please CCP, get your shit sorted ...
					 */
					foreach($data->{$type} as $entityID) {
						switch($type) {
							case 'character':
								$characterSheet = $this->getCharacterData($entityID);

								if($this->isValidEsiData($characterSheet) === true && \strtolower(\trim($characterSheet['data']->name)) === \strtolower(\trim($name))) {
									$returnData = $entityID;

									break;
								} // if($characterSheet['data']->name === $name)
								break;

							case 'corporation':
								$corporationSheet = $this->getCorporationData($entityID);

								if($this->isValidEsiData($corporationSheet) === true && \strtolower(\trim($corporationSheet['data']->corporation_name)) === \strtolower(\trim($name))) {
									$returnData = $entityID;

									break;
								} // if($corporationSheet['data']->name === $name)
								break;

							case 'alliance':
								$allianceSheet = $this->getAllianceData($entityID);

								if($this->isValidEsiData($allianceSheet) === true && \strtolower(\trim($allianceSheet['data']->alliance_name)) === \strtolower(\trim($name))) {
									$returnData = $entityID;

									break;
								} // if($allianceSheet['data']->name === $name)
								break;

							case 'inventorytype':
								$shipSheet = $this->getShipData($entityID);

								if(!\is_null($shipSheet)) {
									$returnData = $entityID;

									break;
								} // if($allianceSheet['data']->name === $name)
								break;

							case 'solarsystem':
								$systemSheet = $this->getSystemData($entityID);

								if($this->isValidEsiData($systemSheet) === true && \strtolower($systemSheet['data']->name) === \strtolower($name)) {
									$returnData = $entityID;

									break;
								} // if($allianceSheet['data']->name === $name)
								break;
						} // switch($type)
					} // foreach($data->{$type} as $entityID)
				} // if(!isset($data->error) && !empty($data))
			} // if(isset($arrayNotInApi[\sanitize_title($name)]))
		} // if(\is_null($returnData))

		return $returnData;
	} // public function getEveIdFromName($name, $type)

	/**
	 * Getting data from the ESI
	 *
	 * @param string $route
	 * @param int $cacheTime Caching time in hours (Default: 120)
	 * @return object
	 */
	private function getEsiData($route, $cacheTime = 120, $parameter = [], $method = 'get') {
		$returnValue = null;
		$data = false;

		switch($method) {
			case 'get':
				$transientName = \sanitize_title('eve-esi-data_' . $route);

				if(!\is_null($cacheTime)) {
					$data = CacheHelper::getInstance()->getTransientCache($transientName);
				} // if(!\is_null($cacheTime))

				if($data === false || empty($data)) {
					$data = RemoteHelper::getInstance()->getRemoteData($this->esiUrl . $route);

					/**
					 * setting the transient caches
					 */
					if(!isset($data->error) && !empty($data) && !\is_null($cacheTime)) {
						CacheHelper::getInstance()->setTransientCache($transientName, $data, $cacheTime);
					} // if(!isset($data->error) && !empty($data) && !\is_null($cacheTime))
				} // if($data === false)
				break;

			case 'post':
				$data = RemoteHelper::getInstance()->getRemoteData($this->esiUrl . $route, $parameter, $method);
				break;
		} // switch($method)

		if(!empty($data) && !isset($data->error)) {
			$returnValue = \json_decode($data);
		} // if(!empty($data))

		return $returnValue;
	} // private function getEsiData($route)

	/**
	 * Check if we have valid ESI data or not
	 *
	 * @param array $esiData
	 * @return boolean
	 */
	public function isValidEsiData($esiData) {
		$returnValue = false;

		if(!\is_null($esiData) && isset($esiData['data']) && !\is_null($esiData['data']) && !isset($esiData['data']->error)) {
			$returnValue = true;
		} // if(!\is_null($esiData) && isset($esiData['data']) && !\is_null($esiData['data']) && !isset($esiData['data']->error))

		return $returnValue;
	} // public function isValidEsiData($esiData)
} // class EveApi
