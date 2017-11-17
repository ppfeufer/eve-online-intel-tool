<div class="dscan-result row">
	<!--
	// Full D-Scan Breakdown
	-->
	<div class="col-md-4 col-sm-6 col-lg-3">
		<?php
		\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
			'title' => \__('All', 'eve-online-intel-tool'),
			'count' => $countAll,
			'shipClassList' => (!empty($intelData['dscanDataAll']['data'])) ? $intelData['dscanDataAll']['data'] : null,
			'pluginSettings' => $pluginSettings
		]);
		?>
	</div>

	<!--
	// On Grid D-Scan Breakdown
	-->
	<div class="col-md-4 col-sm-6 col-lg-3">
		<?php
		\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
			'title' => \__('On Grid', 'eve-online-intel-tool'),
			'count' => $countOnGrid,
			'shipClassList' => (!empty($intelData['dscanDataOnGrid']['data'])) ? $intelData['dscanDataOnGrid']['data'] : null,
			'pluginSettings' => $pluginSettings
		]);
		?>
	</div>

	<!--
	// Off Grid D-Scan Breakdown
	-->
	<div class="col-md-4 col-sm-6 col-lg-3">
		<?php
		\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-classes',[
			'title' => \__('Off Grid', 'eve-online-intel-tool'),
			'count' => $countOffGrid,
			'shipClassList' => (!empty($intelData['dscanDataOffGrid']['data'])) ? $intelData['dscanDataOffGrid']['data'] : null,
			'pluginSettings' => $pluginSettings
		]);
		?>
	</div>

	<!--
	// Ship Types D-Scan Breakdown
	-->
	<div class="col-md-4 col-sm-6 col-lg-3">
		<?php
		\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-types',[
			'title' => \__('Ship Types', 'eve-online-intel-tool'),
			'shipTypeList' => $intelData['dscanDataShipTypes'],
			'pluginSettings' => $pluginSettings
		]);
		?>
	</div>
</div>
