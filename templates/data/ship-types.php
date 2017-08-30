<header class="entry-header"><h2 class="entry-title"><?php echo $title; ?></h2></header>
<?php
if(\is_array($shipTypeList) && \count($shipTypeList) > 0) {
	?>
	<div class="table-responsive table-eve-intel-shiptypes table-eve-intel">
		<table class="table table-condensed table-sortable table-no-images" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
			<thead>
				<th><?php echo \__('Ship Type', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
			</thead>
			<?php
			foreach($shipTypeList as $data) {
				?>
				<tr data-typeclass="<?php echo $data['shipTypeSanitized']; ?>" onmouseover="dscanHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');">
					<td><?php echo $data['type']; ?></td>
					<td class="table-data-count"><?php echo $data['count']; ?></td>
				</tr>
				<?php
			} // END foreach($dscanDataOffGrid['data'] as $data)
			?>
		</table>
	</div>
	<?php
} // END if(\count($dscanDataShipTypes) > 0)
