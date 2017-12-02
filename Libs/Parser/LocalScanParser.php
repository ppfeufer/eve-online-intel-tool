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

class LocalScanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * EVE Swagger Interface
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper
	 */
	private $esiHelper = null;

	/**
	 * Intel Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper
	 */
	private $intelHelper = null;

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct();

		$this->esiHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
		$this->intelHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper::getInstance();
	} // protected function __construct()

	public function parseLocalScan($scanData) {
		$returnValue = null;
		$localArray = $this->getLocalArray($scanData);

		if(!\is_null($localArray)) {
			$employementData = $this->getParticipation($localArray['pilotDetails']);

			$returnValue = [
				'rawData' => $scanData,
				'pilotDetails' => (!\is_null($localArray)) ? $localArray['pilotDetails'] : null,
				'characterList' => (!\is_null($localArray)) ? $localArray['pilotList'] : null,
				'corporationList' => (!\is_null($employementData)) ? $employementData['corporationList'] : null,
				'allianceList' => (!\is_null($employementData)) ? $employementData['allianceList'] : null,
				'corporationParticipation' => (!\is_null($employementData)) ? $employementData['corporationParticipation'] : null,
				'allianceParticipation' => (!\is_null($employementData)) ? $employementData['allianceParticipation'] : null
			];
		} // if(!\is_null($localArray))

		return $returnValue;
	} // END public function parseLocalScan($scanData)

	/**
	 * Parsing the scan data and get an array with every pilots data
	 *
	 * @param string $scanData
	 * @return array
	 */
	public function getLocalArray($scanData) {
		$returnValue = null;
		$searchApi = new \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Api\SearchApi;

		/**
		 * Correcting line breaks
		 *
		 * mac -> linux
		 * windows -> linux
		 */
		$cleanedScanData = $this->intelHelper->fixLineBreaks($scanData);

		$pilotList = [];
		$pilotDetails = [];
		$arrayCharacterIds = [];
		$characterIdChunkSize = 100;

		$scanDataArray = \explode("\n", \trim($cleanedScanData));

		foreach($scanDataArray as $line) {
			/**
			 * Is this a new character, or do we already have that one in our array?
			 */
			if(!isset($arrayCharacterIds[\trim($line)])) {
				/**
				 * Grabbing character information
				 */
				$characterID = $this->esiHelper->getEveIdFromName(\trim($line), 'character');

				if(!\is_null($characterID)) {
					$arrayCharacterIds[\trim($line)] = $characterID;
					$pilotList[$characterID] = $line;
				} // END if(!\is_null($characterID))
			} // if(!isset($arrayCharacterIds[\trim($line)]))
		} // foreach($scanDataArray as $line)

		// loop through the ID sets to get the affiliation data
		foreach(\array_chunk($arrayCharacterIds, $characterIdChunkSize, true) as $idSet) {
			$characterData = $this->esiHelper->getCharacterAffiliation($idSet);
			foreach($characterData['data'] as $affiliatedIds) {
				$pilotDetails[$affiliatedIds->getCharacterId()] = [
					'characterID' => $affiliatedIds->getCharacterId(),
					'characterName' => $pilotList[$affiliatedIds->getCharacterId()]
				];

				/**
				 * Grabbing corporation information
				 */
				if(!\is_null($affiliatedIds->getCorporationId())) {
					$corporationSheet = $this->esiHelper->getCorporationData($affiliatedIds->getCorporationId());

					if(!empty($corporationSheet['data']) && !isset($corporationSheet['data']->error)) {
						$pilotDetails[$affiliatedIds->getCharacterId()]['corporationID'] = $affiliatedIds->getCorporationId();
						$pilotDetails[$affiliatedIds->getCharacterId()]['corporationName'] = $corporationSheet['data']->corporation_name;
						$pilotDetails[$affiliatedIds->getCharacterId()]['corporationTicker'] = $corporationSheet['data']->ticker;
					} // if(!empty($corporationSheet['data']) && !isset($corporationSheet['data']->error))
				} // if(isset($affiliatedIds->getCorporationId()))

				/**
				 * Grabbing alliance information
				 */
				if(!is_null($affiliatedIds->getAllianceId())) {
					$allianceSheet = $this->esiHelper->getAllianceData($affiliatedIds->getAllianceId());

					if(!empty($allianceSheet['data']) && !isset($allianceSheet['data']->error)) {
						$pilotDetails[$affiliatedIds->getCharacterId()]['allianceID'] = (!is_null($affiliatedIds->getAllianceId())) ? $affiliatedIds->getAllianceId() : 0;
						$pilotDetails[$affiliatedIds->getCharacterId()]['allianceName'] = $allianceSheet['data']->alliance_name;
						$pilotDetails[$affiliatedIds->getCharacterId()]['allianceTicker'] = $allianceSheet['data']->ticker;
					} // if(!empty($allianceSheet['data']) && !isset($allianceSheet['data']->error))
				} // if(isset($affiliatedIds->getAllianceId()))
			} // foreach($characterData['data'] as $affiliatedIds)
		} // foreach(\array_chunk($arrayCharacterIds, $characterIdChunkSize, true) as $idSet)

		if(\count($pilotDetails) > 0) {
			$returnValue = [
				'pilotList' => $pilotList,
				'pilotDetails' => $pilotDetails
			];
		} // if(\count($pilotDetails) > 0)

		return $returnValue;
	} // public function getLocalArray($scanData)

	/**
	 * Getting the corporation and alliances involved
	 *
	 * @param array $pilotDetails
	 * @return array
	 */
	public function getParticipation(array $pilotDetails) {
		$returnValue = null;
		$employementList = [];
		$corporationList = [];
		$corporationParticipation = [];
		$allianceList = [];
		$allianceParticipation = [];
		$counter = [];

		foreach($pilotDetails as $pilotSheet) {
			/**
			 * Corporation list
			 */
			if(isset($pilotSheet['corporationID'])) {
				if(!isset($counter[\sanitize_title($pilotSheet['corporationName'])])) {
					$counter[\sanitize_title($pilotSheet['corporationName'])] = 0;
				} // if(!isset($counter[\sanitize_title($pilotSheet['corporationName'])]))

				$counter[\sanitize_title($pilotSheet['corporationName'])]++;

				$corporationList[\sanitize_title($pilotSheet['corporationName'])] = [
					'corporationID' => $pilotSheet['corporationID'],
					'corporationName' => $pilotSheet['corporationName'],
					'corporationTicker' => $pilotSheet['corporationTicker'],
					'allianceID' => (isset($pilotSheet['allianceID'])) ? $pilotSheet['allianceID'] : 0,
					'allianceName' => (isset($pilotSheet['allianceName'])) ? $pilotSheet['allianceName'] : null,
					'allianceTicker' => (isset($pilotSheet['allianceTicker'])) ? $pilotSheet['allianceTicker'] : null
				];

				$corporationParticipation[\sanitize_title($pilotSheet['corporationName'])] = [
					'count' => $counter[\sanitize_title($pilotSheet['corporationName'])],
					'corporationID' => $pilotSheet['corporationID'],
					'corporationName' => $pilotSheet['corporationName'],
					'corporationTicker' => $pilotSheet['corporationTicker'],
					'allianceID' => (isset($pilotSheet['allianceID'])) ? $pilotSheet['allianceID'] : 0,
					'allianceName' => (isset($pilotSheet['allianceName'])) ? $pilotSheet['allianceName'] : null,
					'allianceTicker' => (isset($pilotSheet['allianceTicker'])) ? $pilotSheet['allianceTicker'] : null
				];
			} // END if(isset($pilotSheet['corporationID']))

			/**
			 * Alliance List
			 */
			if(isset($pilotSheet['allianceID'])) {
				if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])])) {
					$counter[\sanitize_title($pilotSheet['allianceName'])] = 0;
				} // if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])]))

				$counter[\sanitize_title($pilotSheet['allianceName'])]++;

				$allianceList[\sanitize_title($pilotSheet['allianceName'])] = [
					'allianceID' => $pilotSheet['allianceID'],
					'allianceName' => $pilotSheet['allianceName'],
					'allianceTicker' => $pilotSheet['allianceTicker']
				];

				$allianceParticipation[\sanitize_title($pilotSheet['allianceName'])] = [
					'count' => $counter[\sanitize_title($pilotSheet['allianceName'])],
					'allianceID' => $pilotSheet['allianceID'],
					'allianceName' => $pilotSheet['allianceName'],
					'allianceTicker' => $pilotSheet['allianceTicker']
				];
			} // if(isset($pilotSheet['allianceID']))

			/**
			 * Unaffiliated pilots with no alliance
			 */
			if(!isset($pilotSheet['allianceID'])) {
				if(!isset($counter[\sanitize_title('Unaffiliated / No Alliance')])) {
					$counter[\sanitize_title('Unaffiliated / No Alliance')] = 0;
				} // if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])]))

				$counter[\sanitize_title('Unaffiliated / No Alliance')]++;

				$allianceList[\sanitize_title('Unaffiliated / No Alliance')] = [
					'allianceID' => 0,
					'allianceName' => \__('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
					'allianceTicker' => null
				];

				$allianceParticipation[\sanitize_title('Unaffiliated / No Alliance')] = [
					'count' => $counter[\sanitize_title('Unaffiliated / No Alliance')],
					'allianceID' => 0,
					'allianceName' => \__('Unaffiliated / No Alliance', 'eve-online-intel-tool'),
					'allianceTicker' => null
				];
			} // if(!isset($pilotSheet['allianceID']))
		} // foreach($pilotDetails as $pilotSheet)

		\ksort($corporationList);
		\ksort($corporationParticipation);
		\ksort($allianceList);
		\ksort($allianceParticipation);

		/**
		 * Sorting corporations
		 */
		$employementList['corporationList'] = $corporationList;
		foreach($corporationParticipation as $corporation) {
			$employementList['corporationParticipation'][$corporation['count']][\sanitize_title($corporation['corporationName'])] = $corporation;
		} // foreach($corporationParticipation as $corporation)

		/**
		 * Sorting alliances
		 */
		$employementList['allianceList'] = $allianceList;
		foreach($allianceParticipation as $alliance) {
			$employementList['allianceParticipation'][$alliance['count']][\sanitize_title($alliance['allianceName'])] = $alliance;
		} // foreach($allianceParticipation as $alliance)

		\krsort($employementList['corporationParticipation']);
		\krsort($employementList['allianceParticipation']);

		if(\count($employementList) > 0) {
			$returnValue = $employementList;
		} // if(\count($employementList) > 0)

		unset($counter);

		return $returnValue;
	} // public function getCorporationAndAllianceList(array $pilotDetails)
} // class LocalScanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
