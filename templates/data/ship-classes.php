<header class="entry-header"><h2 class="entry-title"><?php echo $title; ?><?php if(isset($count)) {echo ' (' . $count . ')';} ?></h2></header>
<?php
if(\is_array($shipClassList) && \count($shipClassList) > 0) {
	?>
	<div class="table-responsive table-eve-intel-shipclasses table-eve-intel">
		<table class="table table-sortable table-condensed" data-haspaging="no" data-order='[[ 1, "desc" ]]'>
			<thead>
				<th><?php echo \__('Ship Class', 'eve-online-intel-tool'); ?></th>
				<th><?php echo \__('Count', 'eve-online-intel-tool'); ?></th>
			</thead>
			<?php
			foreach($shipClassList as $data) {
				?>
				<tr data-highlight="shiptype-<?php echo $data['shipTypeSanitized']; ?>">
					<td>
						<?php
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('data/ship-image',[
							'data' => $data,
							'pluginSettings' => $pluginSettings
						]);

						echo $data['shipName'];
						?>
					</td>
					<td class="table-data-count">
						<?php echo $data['count']; ?>
					</td>
				</tr>
				<?php
			} // END foreach($dscanDataOffGrid['data'] as $data)
			?>
		</table>
	</div>
	<?php
} // END if(\count($dscanDataShipTypes) > 0)
