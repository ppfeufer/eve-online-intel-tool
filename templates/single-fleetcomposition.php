<?php
defined('ABSPATH') or die();

// Meta data
$fleetOverview = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetOverview', true));
$fleetInformation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-fleetInformation', true));

$shipClasses = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipClasses', true));
$shipTypes = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-shipTypes', true));

$pilotList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotList', true));
$pilotParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-pilotDetails', true));

$corporationList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationList', true));
$corporationParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-corporationParticipation', true));

$allianceList = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceList', true));
$allianceParticipation = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-allianceParticipation', true));

$fleetScanDataTime = \maybe_unserialize(\get_post_meta(\get_the_ID(), 'eve-intel-tool_fleetcomposition-time', true));
?>

<header class="page-title">
	<h1>
		<?php echo \__('Fleet Composition', 'eve-online-intel-tool'); ?>
	</h1>

	<?php
	if(!empty($fleetScanDataTime)) {
		echo '<small>' . \__('EVE Time:', 'eve-online-intel-tool') . ' ' . $fleetScanDataTime . '</small>';
	} // END if(!empty($dscanDataTime))

	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('extra/buttons');
	?>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-dscan'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="fleetcomposition-information row">
				<!--
				// General fleet information
				-->
				<?php
				if(\is_array($shipTypes) && \count($shipTypes)) {
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/fleet-information',[
						'pilotCount' => \count($pilotList),
						'fleetInformation' => $fleetInformation
					]);
				} // END if(\is_array($shipTypes) && \count($shipTypes))
				?>
			</div>

			<div class="fleetcomposition-result row">
				<!--
				// Ship class overview
				-->
				<div class="col-md-6 col-lg-3">
					<?php
					if(\is_array($shipClasses) && \count($shipClasses)) {
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
							'title' => \__('Ship Classes', 'eve-online-intel-tool'),
							'shipClassList' => $shipClasses
						]);
					} // END if(\is_array($shipClasses) && \count($shipClasses))
					?>
				</div>

				<!--
				// Ship type overview
				-->
				<div class="col-md-6 col-lg-3">
					<?php
					if(\is_array($shipTypes) && \count($shipTypes)) {
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-types',[
							'title' => \__('Ship Types', 'eve-online-intel-tool'),
							'shipTypeList' => $shipTypes
						]);
					} // END if(\is_array($shipTypes) && \count($shipTypes))
					?>
				</div>

				<!--
				// Who is flying what?
				-->
				<div class="col-md-12 col-lg-6">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/fleet-composition',[
						'fleetOverview' => $fleetOverview
					]);
					?>
				</div>
			</div>

			<div class="fleetcomposition-result row">
				<!--
				// Alliance participation
				-->
				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/alliance-participation',[
						'allianceCount' => \count($allianceList),
						'allianceParticipation' => $allianceParticipation
					]);
					?>
				</div>

				<!--
				// Corporation participation
				-->
				<div class="col-md-6 col-lg-3">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/corporation-participation',[
						'corporationCount' => \count($corporationList),
						'corporationParticipation' => $corporationParticipation
					]);
					?>
				</div>

				<!--
				// Pilots participation and breakdown to corporations and alliances
				-->
				<div class="col-md-12 col-lg-6">
					<?php
					\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/pilot-participation',[
						'pilotCount' => \count($pilotList),
						'pilotParticipation' => $pilotParticipation
					]);
					?>
				</div>
			</div>
		</div>
	</section>
</article><!-- /.post-->
