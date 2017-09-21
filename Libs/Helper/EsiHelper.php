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
		}

		if(!$this->imageHelper instanceof \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper) {
			$this->imageHelper = ImageHelper::getInstance();
			$this->imageserverEndpoints = $this->imageHelper->getImageserverEndpoints();
			$this->imageserverUrl = $this->imageHelper->getImageServerUrl();
		}

		$this->esiUrl = $this->getEsiUrl();
		$this->esiEndpoints = $this->getEsiEndpoints();
	} // END public function __construct()

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
		$shipData = $this->getEsiData($this->esiEndpoints['type-information'] . $shipID . '/', 3600);

		return [
			'data' => $shipData
		];
	} // END public function getShipData($shipID)

	public function getShipClassData($shipID) {
		$shipData = $this->getShipData($shipID);
		$shipClassData = $this->getEsiData($this->esiEndpoints['group-information'] . $shipData['data']->group_id . '/', 3600);

		return [
			'data' => $shipClassData
		];
	} // END public function getShipClassData($shipID)

	public function getCharacterData($characterID) {
		$characterData = $this->getEsiData($this->esiEndpoints['character-information'] . $characterID . '/', $this->pluginSettings['pilot-data-cache-time']);

		return [
			'data' => $characterData
		];
	} // END public function getCharacterData($characterID)

	public function getCorporationData($corporationID) {
		$corporationData = $this->getEsiData($this->esiEndpoints['corporation-information'] . $corporationID . '/', $this->pluginSettings['corp-data-cache-time']);

		return [
			'data' => $corporationData
		];
	} // END public function getCorporationData($corporationID)

	public function getAllianceData($allianceID) {
		$allianceData = $this->getEsiData($this->esiEndpoints['alliance-information'] . $allianceID . '/', $this->pluginSettings['alliance-data-cache-time']);

		return [
			'data' => $allianceData
		];
	} // END public function getAllianceData($allianceID)

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
	} // END public function getSystemData($systemID)

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
	} // END public function getConstellationData($constellationID)

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
	} // END public function getRegionData($regionID)

	/**
	 * Get the ship image by ship ID
	 *
	 * @param int $shipTypeID
	 * @param string $shiptype
	 * @param boolean $imageOnly
	 * @param int $size
	 * @return string
	 */
	public function getShipImageById($shipTypeID, $imageOnly = true, $size = 128) {
		$ship = $this->getShipData($shipTypeID);

		$imagePath = ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', $this->imageserverUrl . $this->imageserverEndpoints['inventory'] . $shipTypeID . '_' . $size. '.png');

		if($imageOnly === true) {
			return $imagePath;
		} // END if($imageOnly === true)

		$html = '<img src="' . $imagePath . '" class="eve-character-image eve-ship-id-' . $shipTypeID . '" alt="' . \esc_html($ship['data']->name) . '" data-title="' . \esc_html($ship['data']->name) . '" data-toggle="eve-killboard-tooltip">';

		return $html;
	} // END public function getCorporationImageById($corporationID, $imageOnly = true, $size = 128)

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

		if(isset($arrayNotInApi[\sanitize_title($name)])) {
			$returnData = $arrayNotInApi[\sanitize_title($name)]['id'];
		} else {
			$data = $this->getEsiData($this->esiEndpoints['search'] . '?search=' . \urlencode(\wp_specialchars_decode($name, \ENT_QUOTES)) . '&strict=true&categories=' . $type, 3600);

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

							if($this->isValidEsiData($characterSheet) === true && \strtolower($characterSheet['data']->name) === \strtolower($name)) {
								$returnData = $entityID;
								break;
							} // END if($characterSheet['data']->name === $name)
							break;

						case 'corporation':
							$corporationSheet = $this->getCorporationData($entityID);

							if($this->isValidEsiData($corporationSheet) === true && \strtolower($corporationSheet['data']->corporation_name) === \strtolower($name)) {
								$returnData = $entityID;
								break;
							} // END if($corporationSheet['data']->name === $name)
							break;

						case 'alliance':
							$allianceSheet = $this->getAllianceData($entityID);

							if($this->isValidEsiData($allianceSheet) === true && \strtolower($allianceSheet['data']->alliance_name) === \strtolower($name)) {
								$returnData = $entityID;
								break;
							} // END if($allianceSheet['data']->name === $name)
							break;

						case 'inventorytype':
							$shipSheet = $this->getShipData($entityID);

							if($this->isValidEsiData($shipSheet) === true && \strtolower($shipSheet['data']->name) === \strtolower($name)) {
								$returnData = $entityID;
								break;
							} // END if($allianceSheet['data']->name === $name)
							break;

						case 'solarsystem':
							$systemSheet = $this->getSystemData($entityID);

							if($this->isValidEsiData($systemSheet) === true && \strtolower($systemSheet['data']->name) === \strtolower($name)) {
								$returnData = $entityID;
								break;
							} // END if($allianceSheet['data']->name === $name)
							break;
					} // END switch($type)
				} // END foreach($data->{$type} as $entityID)
			} // END if(!isset($data->error) && !empty($data))
		}

		return $returnData;
	} // END public function getEveIdFromName($name, $type)

	/**
	 * Getting data from the ESI
	 *
	 * @param string $route
	 * @param int $cacheTime Caching time in hours (Default: 120)
	 * @return object
	 */
	private function getEsiData($route, $cacheTime = 120) {
		$returnValue = null;
		$transientName = \sanitize_title('eve-esi-data_' . $route);
		$data = CacheHelper::getInstance()->getTransientCache($transientName);

		if($data === false || empty($data)) {
			$data = RemoteHelper::getInstance()->getRemoteData($this->esiUrl . $route);

			/**
			 * setting the transient caches
			 */
			if(!isset($data->error) && !empty($data)) {
				CacheHelper::getInstance()->setTransientCache($transientName, $data, $cacheTime);
			} // END if(!isset($data->error))
		} // END if($data === false)

		if(!empty($data) && !isset($data->error)) {
			$returnValue = \json_decode($data);
		} // END if(!empty($data))

		return $returnValue;
	} // END private function getEsiData($route)

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
		} // END if(!\is_null($esiData) && isset($esiData['data']) && !\is_null($esiData['data']) && !isset($esiData['data']->error))

		return $returnValue;
	} // END public function isValidEsiData($esiData)
} // END class EveApi
