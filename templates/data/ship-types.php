<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Types', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(\is_array($shipTypeList) && \count($shipTypeList) > 0) {
	?>
	<div class="table-responsive table-eve-intel-shiptypes table-eve-intel table-no-images">
		<table class="table table-condensed">
			<?php
			foreach($shipTypeList as $data) {
				?>
				<tr data-typeclass="<?php echo $data['shipTypeSanitized']; ?>" onmouseover="dscanHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');">
					<td><?php echo $data['type']; ?></td>
					<td><?php echo $data['count']; ?></td>
				</tr>
				<?php
			} // END foreach($dscanDataOffGrid['data'] as $data)
			?>
		</table>
	</div>
	<?php
} // END if(\count($dscanDataShipTypes) > 0)
