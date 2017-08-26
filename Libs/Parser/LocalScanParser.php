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
	private $esi = null;

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct();

		$this->esi = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\EsiHelper::getInstance();
	} // END protected function __construct()

	public function parseLocalScan($scanData) {
		$returnValue = null;
		$localArray = $this->getLocalArray($scanData);
		$employementData = $this->getParticipation($localArray['pilotDetails']);

		if(!\is_null($localArray)) {
			$returnValue = [
				'rawData' => $scanData,
				'pilotDetails' => (!\is_null($localArray)) ? $localArray['pilotDetails'] : null,
				'characterList' => (!\is_null($localArray)) ? $localArray['pilotList'] : null,
				'corporationList' => (!\is_null($employementData)) ? $employementData['corporationList'] : null,
				'allianceList' => (!\is_null($employementData)) ? $employementData['allianceList'] : null,
				'corporationParticipation' => (!\is_null($employementData)) ? $employementData['corporationParticipation'] : null,
				'allianceParticipation' => (!\is_null($employementData)) ? $employementData['allianceParticipation'] : null
			];
		} // END if(!\is_null($localArray))

		return $returnValue;
	} // END public function parseDscan($scanData)

	/**
	 * Parsing the scan data and get an array with every pilots data
	 *
	 * @param string $scanData
	 * @return array
	 */
	public function getLocalArray($scanData) {
		$returnValue = null;

		/**
		 * Correcting line breaks
		 *
		 * mac -> linux
		 * windows -> linux
		 */
		$cleanedScanData = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\IntelHelper::getInstance()->fixLineBreaks($scanData);

		$pilotList = [];
		$pilotDetails = [];

		foreach(\explode("\n", \trim($cleanedScanData)) as $line) {
			/**
			 * Grabbing character information
			 */
			$characterID = $this->esi->getEveIdFromName($line, 'character');
			$characterSheet = $this->esi->getCharacterData($characterID);


			if(!empty($characterSheet['data']) && !isset($characterSheet['data']->error)) {
				unset($characterSheet['data']->description);

				$pilotList[$characterID] = $line;

				$pilotDetails[$characterID] = [
					'characterID' => $characterID,
					'characterName' => $line
				];

				$characterData = $characterSheet['data'];
				/**
				 * Grabbing corporation information
				 */
				if(isset($characterData->corporation_id)) {
					$corporationSheet = $this->esi->getCorporationData($characterData->corporation_id);

					if(!empty($corporationSheet['data']) && !isset($corporationSheet['data']->error)) {
						$pilotDetails[$characterID]['corporationID'] = $characterData->corporation_id;
						$pilotDetails[$characterID]['corporationName'] = $corporationSheet['data']->corporation_name;
						$pilotDetails[$characterID]['corporationTicker'] = $corporationSheet['data']->ticker;
					} // END if(!empty($corporationSheet['data']) && !isset($corporationSheet['data']->error))
				} // END if(isset($characterData->corporation_id))

				/**
				 * Grabbing alliance information
				 */
				if(isset($characterData->alliance_id)) {
					$allianceSheet = $this->esi->getAllianceData($characterData->alliance_id);

					if(!empty($allianceSheet['data']) && !isset($allianceSheet['data']->error)) {
						$pilotDetails[$characterID]['allianceID'] = $characterData->alliance_id;
						$pilotDetails[$characterID]['allianceName'] = $allianceSheet['data']->alliance_name;
						$pilotDetails[$characterID]['allianceTicker'] = $allianceSheet['data']->ticker;
					} // END if(!empty($allianceSheet['data']) && !isset($allianceSheet['data']->error))
				} // END if(isset($characterData->alliance_id))
			} // END if(!empty($characterSheet['data']) && !isset($characterSheet['data']->error))
		} // END foreach(\explode("\n", \trim($cleanedScanData)) as $line)

		if(\count($pilotDetails) > 0) {
			$returnValue = [
				'pilotList' => $pilotList,
				'pilotDetails' => $pilotDetails
			];
		} // END if(\count($pilotDetails) > 0)

		return $returnValue;
	} // END public function getLocalArray($scanData)

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
				} // END if(!isset($counter[\sanitize_title($pilotSheet['corporationName'])]))
				$counter[\sanitize_title($pilotSheet['corporationName'])]++;

				$corporationList[\sanitize_title($pilotSheet['corporationName'])] = [
					'corporationID' => $pilotSheet['corporationID'],
					'corporationName' => $pilotSheet['corporationName'],
					'corporationTicker' => $pilotSheet['corporationTicker']
				];

				$corporationParticipation[\sanitize_title($pilotSheet['corporationName'])] = [
					'corporationID' => $pilotSheet['corporationID'],
					'corporationName' => $pilotSheet['corporationName'],
					'count' => $counter[\sanitize_title($pilotSheet['corporationName'])]
				];
			} // END if(isset($pilotSheet['corporationID']))

			/**
			 * Alliance List
			 */
			if(isset($pilotSheet['allianceID'])) {
				if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])])) {
					$counter[\sanitize_title($pilotSheet['allianceName'])] = 0;
				} // END if(!isset($counter[\sanitize_title($pilotSheet['allianceName'])]))
				$counter[\sanitize_title($pilotSheet['allianceName'])]++;

				$allianceList[\sanitize_title($pilotSheet['allianceName'])] = [
					'allianceID' => $pilotSheet['allianceID'],
					'allianceName' => $pilotSheet['allianceName'],
					'allianceTicker' => $pilotSheet['allianceTicker']
				];

				$allianceParticipation[\sanitize_title($pilotSheet['allianceName'])] = [
					'allianceID' => $pilotSheet['allianceID'],
					'allianceName' => $pilotSheet['allianceName'],
					'count' => $counter[\sanitize_title($pilotSheet['allianceName'])]
				];
			} // END if(isset($pilotSheet['characterData']->corporation_id))
		} // END foreach($pilotDetails as $pilotSheet)

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
		}

		/**
		 * Sorting alliances
		 */
		$employementList['allianceList'] = $allianceList;
		foreach($allianceParticipation as $alliance) {
			$employementList['allianceParticipation'][$alliance['count']][\sanitize_title($alliance['allianceName'])] = $alliance;
		}

		\krsort($employementList['corporationParticipation']);
		\krsort($employementList['allianceParticipation']);

		if(\count($employementList) > 0) {
			$returnValue = $employementList;
		} // END if(\count($employementList) > 0)

		unset($counter);

		return $returnValue;
	} // END public function getCorporationAndAllianceList(array $pilotDetails)
} // END class LocalScanParser extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
