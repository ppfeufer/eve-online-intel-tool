<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Types', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(\is_array($shipTypeList) && \count($shipTypeList) > 0) {
	foreach($shipTypeList as $data) {
		?>
		<div data-typeclass="<?php echo $data['shipClassSanitized']; ?>" class="dscan-row" onmouseover="dscanHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipClassSanitized']; ?>');">
			<span class="dscan-ship-count"><?php echo $data['count']; ?></span>
			<span class="dscan-ship-type"><?php echo $data['type']; ?></span>
		</div>
		<?php
	} // END foreach($dscanDataOffGrid['data'] as $data)
} // END if(\count($dscanDataShipTypes) > 0)
