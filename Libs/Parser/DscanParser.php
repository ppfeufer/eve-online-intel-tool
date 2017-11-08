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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Parser;

\defined('ABSPATH') or die();

class DscanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * EVE Swagger Interface
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper
	 */
	private $esi = null;

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct();

		$this->esi = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
	} // END protected function __construct()

	/**
	 * Breaking down the D-Scan into arrays
	 *
	 * @param string $scanData
	 * @return array
	 */
	public function getDscanArray($scanData) {
		/**
		 * Correcting line breaks
		 *
		 * mac -> linux
		 * windows -> linux
		 */
		$cleanedScanData = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper::getInstance()->fixLineBreaks($scanData);

		$dscanDetailShipsAll = [];
		$dscanDetailShipsOnGrid = [];
		$dscanDetailShipsOffGrid = [];

		foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
			$lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

			$shipData = $this->esi->getShipData($lineDetailsArray['0']);

			if($shipData['data']['shipData'] !== null && $shipData['data']['shipTypeData'] !== null) {
				$dscanDetailShipsAll[] = [
					'dscanData' => $lineDetailsArray,
					'shipData' => $shipData['data']['shipData'],
					'shipClass' => $shipData['data']['shipTypeData']
				];

				/**
				 * Determine OnGrid and OffGrid
				 */
				if($lineDetailsArray['3'] === '-') {
					$dscanDetailShipsOffGrid[] = [
						'dscanData' => $lineDetailsArray,
						'shipData' => $shipData['data']['shipData'],
						'shipClass' => $shipData['data']['shipTypeData']
					];
				} else {
					$dscanDetailShipsOnGrid[] = [
						'dscanData' => $lineDetailsArray,
						'shipData' => $shipData['data']['shipData'],
						'shipClass' => $shipData['data']['shipTypeData']
					];
				} // END if($lineDetailsArray['3'] === '-')
			} // END if($shipData !== null && $shipClass !== null)
		} // END foreach(\explode("\n", trim($cleanedScanData)) as $line)

		// Let's see if we can find out in what system we are ....
		$system = $this->detectSystem($cleanedScanData);

		$dscanArray = [
			'all' => [
				'count' => \count($dscanDetailShipsAll),
				'data' => $dscanDetailShipsAll
			],
			'onGrid' => [
				'count' => \count($dscanDetailShipsOnGrid),
				'data' => $dscanDetailShipsOnGrid
			],
			'offGrid' => [
				'count' => \count($dscanDetailShipsOffGrid),
				'data' => $dscanDetailShipsOffGrid
			],
			'system' => $system
		];

		return $dscanArray;
	} // END public function parseDscan($scanData)

	/**
	 * Try and detect the system the scan was made in
	 *
	 * @param string $cleanedScanData
	 * @return array
	 */
	public function detectSystem($cleanedScanData) {
		$returnValue = null;
		$systemFound = false;
		$systemName = null;

		// These ID's have the system name in their name
		$arraySystemIds = [
			/**
			 * Citadels
			 */
			'35832', // Astrahus
			'35833', // Fortizar
			'35834', // Keepstar
			'40340', // Upwell Palatine Keepstar

			/**
			 * Engeneering Complexes
			 */
			'35825', // Raitaru
			'35826', // Azbel
			'35827', // Sotiyo

			/**
			 * Refineries
			 */
			'35835', // Athanor
			'35836', // Tatara
		];

		/**
		 * Trying to find the system by one of the structure IDs
		 */
		foreach(\explode("\n", trim($cleanedScanData)) as $line) {
			$lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

			if(\in_array($lineDetailsArray['0'], $arraySystemIds)) {
				$parts = \explode(' - ', $lineDetailsArray['1']);
				$systemName = \trim($parts['0']);

				$systemFound = true;
			} // END if(\in_array($line['0'], $arraySystemIds))
		} // END foreach(\explode("\n", trim($cleanedScanData)) as $line)

		/**
		 * Determine system by its sun
		 */
		if($systemFound === false) {
			foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
				$lineDetailsArray = \explode("\t", \str_replace('*', '', \trim($line)));

				if(\preg_match('/(.*) - Star/', $lineDetailsArray['1']) && \preg_match('/Sun (.*)/', $lineDetailsArray['2'])) {
					$systemName = \trim(\str_replace(' - Star', '', $lineDetailsArray['1']));
				} // END if(\preg_match('/(.*) - Star/', $line['0']) && preg_match('/Sun (.*)/', $line['1']))
			} // END foreach(\explode("\n", trim($cleanedScanData)) as $line)
		} // END if($systemFound === false)

		if($systemName !== null) {
			$systemID = $this->esi->getEveIdFromName(\trim($systemName), 'solarsystem');
			$systemData = $this->esi->getSystemData($systemID);
			$constellationData = null;
			$regionData = null;

			$constellationName = null;
			$regionName = null;

			// Get the constellation data
			if($this->esi->isValidEsiData($systemData) === true) {
				$constellationData = $this->esi->getConstellationData($systemData['data']->constellation_id);
			} // END if($this->esi->isValidEsiData($systemData) === true)

			// Get the region data
			if($this->esi->isValidEsiData($constellationData) === true) {
				// Set the constellation name
				$constellationName = $constellationData['data']->name;
				$regionData = $this->esi->getRegionData($constellationData['data']->region_id);
			} // END if($this->esi->isValidEsiData($constellationData) === true)

			// Set the region name
			if($this->esi->isValidEsiData($regionData) === true) {
				$regionName = $regionData['data']->name;
			} // END if($this->esi->isValidEsiData($regionData) === true)

			$returnValue = [
				'systemName' => $systemName,
				'constellationName' => $constellationName,
				'regionName' => $regionName
			];
		} // END if($system !== null)

		return $returnValue;
	} // END public function detectSystem($cleanedScanData)

	/**
	 * Parsing the D-Scan arrays
	 *
	 * @param array $dscanArray
	 * @return array
	 */
	public function parseScanArray(array $dscanArray) {
		$returnData = null;
		$countShipClasses = [];
		$dscanDetails = [];
		$count = [];
		$shipCounter = 0;

		foreach($dscanArray['data'] as $item) {
			switch($item['shipClass']->category_id) {
				// only ships
				case 6:
					/**
					 * Counter Ship Types
					 */
					$count[$item['dscanData']['0']]['all'][] = '';
					$dscanDetails['count'] = ++$shipCounter;

					/**
					 * Counter Ship Classes
					 */
					$countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->name)]['shipClass'] = (string) $item['shipClass']->name;
					$countShipClasses['shipClass_' . \sanitize_title((string) $item['shipClass']->name)]['counter'][] = '';

					/**
					 * Ship breakdown
					 */
					$dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipID'] = $item['dscanData']['0'];
					$dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipName'] = $item['dscanData']['2'];
					$dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['count'] = \count($count[$item['dscanData']['0']]['all']);
					$dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipClass'] = $item['shipClass']->name;
					$dscanDetails['data'][\sanitize_title((string) $item['dscanData']['2'])]['shipTypeSanitized'] = \sanitize_title((string) $item['shipClass']->name);

					break;

				default:
					break;
			} // END switch($item['shipClass']->category_id)
		} // END foreach($dscanArray['data'] as $item)

		if(!empty($dscanDetails['data'])) {
			\ksort($dscanDetails['data']);
		}

		$returnData = $dscanDetails;

		return $returnData;
	} // END public function parseScanArray(array $dscanArray)

	/**
	 * Parsing the D-Scan
	 *
	 * @param string $scanData
	 * @return array
	 */
	public function parseDscan($scanData) {
		$returnData = null;
		$dscanAll = null;
		$dscanOnGrid = null;
		$dscanOffGrid = null;

		$dscanArray = $this->getDscanArray($scanData);

		if($dscanArray['all']['count'] !== 0) {
			$dscanAll = $this->parseScanArray($dscanArray['all']);
			$returnData['all'] = $dscanAll;

			$returnData['shipTypes'] = $this->getShipTypesArray($dscanArray['all']['data']);
			$returnData['upwellStructures'] = $this->getUpwellStructuresArray($dscanArray['all']['data']);
			$returnData['deployables'] = $this->getDeployablesArray($dscanArray['all']['data']);
		} // END if($dscanArray['all']['count'] !== 0)

		if($dscanArray['onGrid']['count'] !== 0) {
			$dscanOnGrid = $this->parseScanArray($dscanArray['onGrid']);
			$returnData['onGrid'] = $dscanOnGrid;
		} // END if($dscanArray['onGrid']['count'] !== 0)

		if($dscanArray['offGrid']['count'] !== 0) {
			$dscanOffGrid = $this->parseScanArray($dscanArray['offGrid']);
			$returnData['offGrid'] = $dscanOffGrid;
		} // END if($dscanArray['onGrid']['count'] !== 0)

		$returnData['system'] = $dscanArray['system'];

		return $returnData;
	} // END public function parseDscan($scanData)

	/**
	 * Getting the shiptypes array
	 *
	 * @param array $dscanArray
	 * @return array
	 */
	public function getShipTypesArray(array $dscanArray) {
		$shipTypeArray = [];
		$count = [];

		foreach($dscanArray as $scanResult) {
			// Ships only ...
			if($scanResult['shipClass']->category_id === 6) {
				if(!isset($count[\sanitize_title($scanResult['shipClass']->name)])) {
					$count[\sanitize_title($scanResult['shipClass']->name)] = 0;
				} // if(!isset($count[\sanitize_title($scanResult['shipClass']->name)]))

				$count[\sanitize_title($scanResult['shipClass']->name)]++;

				$shipTypeArray[\sanitize_title($scanResult['shipClass']->name)] = [
					'type' => $scanResult['shipClass']->name,
					'shipTypeSanitized' => \sanitize_title($scanResult['shipClass']->name),
					'count' => $count[\sanitize_title($scanResult['shipClass']->name)]
				];
			} // END if($scanResult['shipClass']->category_id === 6)
		} // END foreach($dscanArray as $scanResult)

		\ksort($shipTypeArray);

		return $shipTypeArray;
	} // END public function getShipTypesArray(array $dscanArray)

	/**
	 * Getting Upwell structures that are on grid
	 *
	 * @param array $dscanArray
	 * @return array
	 */
	public function getUpwellStructuresArray(array $dscanArray) {
		$shipTypeArray = [];
		$count = [];
		$gridSize = 10000; // our defined grid size in km


		foreach($dscanArray as $scanResult) {
			// Upwell structures on grid only ...
			if($scanResult['shipClass']->category_id === 65 && $scanResult['dscanData']['3'] !== '-') {
				$dscanRangeArray = \explode(' ', $scanResult['dscanData']['3']);
				$range = (int) \number_format((float) \str_replace(',', '.', $dscanRangeArray['0']), 0, '', '');

				/**
				 * Only if the Upwell structure is actually within our defined grid range
				 * Since Upwell structures that are accessable by the pilot
				 * always have a range on d-scans, we need to do it this way ...
				 *
				 * @todo: localized strings for 'km' via preg_match
				 */
				if($range <= $gridSize && $dscanRangeArray['1'] === 'km') {
					if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
						$count[\sanitize_title($scanResult['shipData']->name)] = 0;
					} // if(!isset($count[\sanitize_title($scanResult['shipData']->name)]))

					$count[\sanitize_title($scanResult['shipData']->name)]++;

					$shipTypeArray[\sanitize_title($scanResult['shipData']->name)] = [
						'type' => $scanResult['shipData']->name,
						'type_id' => $scanResult['shipData']->type_id,
						'shipTypeSanitized' => \sanitize_title($scanResult['shipData']->name),
						'count' => $count[\sanitize_title($scanResult['shipData']->name)]
					];
				} // if($range <= $gridSize && $dscanRangeArray['1'] === 'km')
			} // if($scanResult['shipClass']->category_id === 65 && $scanResult['dscanData']['3'] !== '-')
		} // END foreach($dscanArray as $scanResult)

		\ksort($shipTypeArray);

		return $shipTypeArray;
	} // public function getUpwellStructuresArray(array $dscanArray)

	/**
	 * Getting deployables that are on grid
	 *
	 * @param array $dscanArray
	 * @return array
	 */
	public function getDeployablesArray(array $dscanArray) {
		$shipTypeArray = [];
		$count = [];

		foreach($dscanArray as $scanResult) {
			// Deployable structures on grid only ...
			if($scanResult['shipClass']->category_id === 22 && $scanResult['dscanData']['3'] !== '-') {
				if(!isset($count[\sanitize_title($scanResult['shipData']->name)])) {
					$count[\sanitize_title($scanResult['shipData']->name)] = 0;
				} // if(!isset($count[\sanitize_title($scanResult['shipData']->name)]))

				$count[\sanitize_title($scanResult['shipData']->name)]++;

				$shipTypeArray[\sanitize_title($scanResult['shipData']->name)] = [
					'type' => $scanResult['shipData']->name,
					'type_id' => $scanResult['shipData']->type_id,
					'shipTypeSanitized' => \sanitize_title($scanResult['shipData']->name),
					'count' => \count($count[\sanitize_title($scanResult['shipData']->name)])
				];
			} // if($scanResult['shipClass']->category_id === 65 && $scanResult['dscanData']['3'] !== '-')
		} // END foreach($dscanArray as $scanResult)

		\ksort($shipTypeArray);

		return $shipTypeArray;
	} // public function getUpwellStructuresArray(array $dscanArray)
} // END class DscanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
