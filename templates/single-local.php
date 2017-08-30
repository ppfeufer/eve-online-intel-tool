<?php
defined('ABSPATH') or die();

$localDataPilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotList', true));
$localDataPilotDetails = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-pilotDetails', true), [false]);

$localDataCorporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationList', true));
$localDataCorporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-corporationParticipation', true));

$localDataAllianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceList', true));
$localDataAllianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-allianceParticipation', true));

$localDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_local-time', true));
?>

<header class="page-title">
	<h1>
		<?php
		echo \__('Chat Scan', 'eve-online-intel-tool');
		?>
	</h1>

	<?php
	if(!empty($localDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $localDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-local'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="local-scan-result row">
				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/alliance-participation',[
						'allianceCount' => \count($localDataAllianceList),
						'allianceParticipation' => $localDataAllianceParticipation
					]);
					?>
				</div>

				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/corporation-participation',[
						'corporationCount' => \count($localDataCorporationList),
						'corporationParticipation' => $localDataCorporationParticipation
					]);
					?>
				</div>

				<div class="col-md-12 col-lg-6">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/pilot-participation',[
						'pilotCount' => \count($localDataPilotList),
						'pilotParticipation' => $localDataPilotDetails
					]);
					?>
				</div>
			</div>
		</div>
	</section>
</article><!-- /.post-->
