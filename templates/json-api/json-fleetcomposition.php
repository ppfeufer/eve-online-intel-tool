<?php
defined('ABSPATH') or die();

// Meta data
$fleetOverview = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetOverview', true));
$shipClasses = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipClasses', true));
$shipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipTypes', true));

$pilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotList', true));
$pilotParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotDetails', true));

$corporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationList', true));
$corporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationParticipation', true));

$allianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceList', true));
$allianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceParticipation', true));

$fleetScanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-time', true));

$jsonData = [
	'overview' => $fleetOverview,
	'shipClasses' => $shipClasses,
	'shipTypes' => $shipTypes,

	'pilotCount' => \count($pilotList),
	'pilotList' => $pilotList,
	'pilotDetails' => $pilotParticipation,

	'corporationList' => $corporationList,
	'corporationParticipation' => $corporationParticipation,

	'allianceList' => $allianceList,
	'allianceParticipation' => $allianceParticipation,

	'eveTime' => $fleetScanDataTime
];

echo \json_encode($jsonData);

// Always exit the API route, so it doesn't load the actual page
exit;
