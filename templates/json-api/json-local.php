<?php
// Meta data
$localDataPilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotList', true));
$localDataPilotDetails = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotDetails', true), [false]);

$localDataCorporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationList', true));
$localDataCorporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationParticipation', true));

$localDataAllianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceList', true));
$localDataAllianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceParticipation', true));

$localDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-time', true));

$jsonData = [
	'pilotCount' => \count($localDataPilotList),
	'pilotList' => $localDataPilotList,
	'pilotDetails' => $localDataPilotDetails,

	'corporationList' => $localDataCorporationList,
	'corporationParticipation' => $localDataCorporationParticipation,

	'allianceList' => $localDataAllianceList,
	'allianceParticipation' => $localDataAllianceParticipation,

	'eveTime' => $localDataTime
];

echo \json_encode($jsonData);

// Always exit the API route, so it doesn't load the actual page
exit;
