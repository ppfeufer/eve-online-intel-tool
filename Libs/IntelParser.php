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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs;

\defined('ABSPATH') or die();

/**
 * Parsing our intel data
 */
class IntelParser {
	/**
	 * Intel data to parse
	 *
	 * @var string
	 */
	public $eveIntel = null;

	/**
	 * Unique ID for this run
	 *
	 * @var string
	 */
	public $uniqueID = null;

	/**
	 * ID of the new post
	 *
	 * @var int
	 */
	public $postID = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->eveIntel = \filter_input(INPUT_POST, 'eveIntel');
		$this->uniqueID = \uniqid();

		/**
		 * Let's get the intel type
		 * dscan / fleetcomposition / local
		 */
		$intelType = $this->checkIntelType($this->eveIntel);

		switch($intelType) {
			case 'dscan':
				$this->postID = $this->saveDscanData($this->eveIntel);
				break;

			case 'fleetcomposition':
				$this->postID = $this->saveFleetComositionData($this->eveIntel);
				break;

			case 'local':
				$this->postID = $this->saveLocalScanData($this->eveIntel);
				break;

			default:
				break;
		} // END switch($intelType)
	} // END public function __construct()

	/**
	 * Determine what type of intel we might have
	 *
	 * @param string $scanData
	 * @return string
	 */
	private function checkIntelType($scanData) {
		$intelType = null;

		/**
		 * Correcting line breaks
		 *
		 * mac -> linux
		 * windows -> linux
		 */
		$cleanedScanData = Helper\IntelHelper::getInstance()->fixLineBreaks($scanData);

		switch($cleanedScanData) {
			case (\preg_match('/^\d+(.*)(-|AU) ?$/m', $cleanedScanData) ? true : false):
				$intelType =  'dscan';
				break;

			case (\preg_match('/\w+ \/ \w+( \d+)? ?$/m', $cleanedScanData) ? true : false):
				$intelType =  'fleetcomposition';
				break;

			case (\preg_match('/^[a-zA-Z0-9 -_]{3,37}$/m', $cleanedScanData) ? true : false):
				$intelType =  'local';
				break;

			default:
				break;
		} // END switch($cleanedScanData)

		return $intelType;
	} // END private function checkIntelType($scanData)

	/**
	 * Saving the D-Scan data
	 *
	 * @param string $scanData
	 * @return int
	 */
	private function saveDscanData($scanData) {
		$returnData = null;

		$parsedDscanData = Parser\DscanParser::getInstance()->parseDscan($scanData);

		if($parsedDscanData !== null) {
			$uniqueID = \uniqid();
			$postTitle = $uniqueID;

			/**
			 * If we have a system, add it to the post title
			 */
			if(!empty($parsedDscanData['system']['name'])) {
				$postTitle = $parsedDscanData['system']['name'] . ' ' . $uniqueID;
			} // END if(!empty($parsedDscanData['system']['name']))

			$newPostID = \wp_insert_post([
				'post_title' => $postTitle,
				'post_content' => '',
				'post_category' => '',
				'post_status' => 'publish',
				'post_type' => 'intel',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'meta_input' => [
					'eve-intel-tool_dscan-rawData' => Helper\IntelHelper::getInstance()->fixLineBreaks($scanData),
					'eve-intel-tool_dscan-all' => \serialize($parsedDscanData['all']),
					'eve-intel-tool_dscan-onGrid' => \serialize($parsedDscanData['onGrid']),
					'eve-intel-tool_dscan-offGrid' => \serialize($parsedDscanData['offGrid']),
					'eve-intel-tool_dscan-shipTypes' => \serialize($parsedDscanData['shipTypes']),
					'eve-intel-tool_dscan-system' => \serialize($parsedDscanData['system']),
					'eve-intel-tool_dscan-time' => \gmdate("Y-m-d H:i:s", time()),
				]
			], true);

			if($newPostID) {
				\wp_set_object_terms($newPostID, 'dscan', 'intel_category');

				$returnData = $newPostID;
			} // END if($newPostID)
		} // END if($parsedDscanData !== null)

		return $returnData;
	} // END private function saveDscanData($scanData)

	private function saveFleetComositionData($scanData) {
		return null;
	} // END private function saveFleetComositionData($scanData)

	private function saveLocalScanData($scanData) {
		$returnData = null;

		$parsedLocalData = Parser\LocalScanParser::getInstance()->parseLocalScan($scanData);

		if($parsedLocalData !== null) {
			$uniqueID = \uniqid();
			$postTitle = $uniqueID;

			$newPostID = \wp_insert_post([
				'post_title' => $postTitle,
				'post_content' => '',
				'post_category' => '',
				'post_status' => 'publish',
				'post_type' => 'intel',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'meta_input' => [
					'eve-intel-tool_local-rawData' => \maybe_serialize($parsedLocalData['rawData']),
					'eve-intel-tool_local-pilotDetails' => \maybe_serialize($parsedLocalData['pilotDetails']),
					'eve-intel-tool_local-pilotList' => \maybe_serialize($parsedLocalData['characterList']),
					'eve-intel-tool_local-corporationList' => \maybe_serialize($parsedLocalData['corporationList']),
					'eve-intel-tool_local-allianceList' => \maybe_serialize($parsedLocalData['allianceList']),
					'eve-intel-tool_local-corporationParticipation' => \maybe_serialize($parsedLocalData['corporationParticipation']),
					'eve-intel-tool_local-allianceParticipation' => \maybe_serialize($parsedLocalData['allianceParticipation']),
					'eve-intel-tool_local-time' => \maybe_serialize(\gmdate("Y-m-d H:i:s", time())),
				]
			], true);

			if($newPostID) {
				\wp_set_object_terms($newPostID, 'local', 'intel_category');

				$returnData = $newPostID;
			} // END if($newPostID)
		} // END if($parsedDscanData !== null)

		return $returnData;
	} // END private function saveFleetComositionData($scanData)
} // END class IntelParser
