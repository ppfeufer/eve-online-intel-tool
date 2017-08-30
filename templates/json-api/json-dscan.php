<?php
// Meta data
$dscanDataAll = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-all', true));
$dscanDataOnGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-onGrid', true));
$dscanDataOffGrid = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-offGrid', true));

$dscanDataShipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-shipTypes', true));
$dscanDataSystem = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-system', true));

$dscanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_dscan-time', true));

$jsonData = [
	'dscanAll' => $dscanDataAll,
	'dscanOngrid' => $dscanDataOnGrid,
	'dscanOffgrid' => $dscanDataOffGrid,

	'dscanShipTypes' => $dscanDataShipTypes,
	'dscanSystemInformation' => $dscanDataSystem,

	'eveTime' => $dscanDataTime
];

echo \json_encode($jsonData);

// Always exit the API route, so it doesn't load the actual page
exit;
