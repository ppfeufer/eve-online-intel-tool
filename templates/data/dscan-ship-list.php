<header class="entry-header"><h2 class="entry-title"><?php echo $title; ?> (<?php echo $count; ?>)</h2></header>
<?php
if(!empty($shipTypeList)) {
	?>
	<div class="table-responsive table-eve-intel-shipclasses table-eve-intel">
		<table class="table table-condensed">
			<?php
			foreach($shipTypeList as $data) {
				?>
				<tr data-typeclass="<?php echo $data['shipTypeSanitized']; ?>" title="<?php echo $data['shipClass']; ?>" onmouseover="dscanHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');">
					<td>
						<?php
						$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('inventory') . $data['itemID'] . '_32.png');
						?>
						<img src="<?php echo $image; ?>" alt="<?php echo $data['type']; ?>" width="32" heigh="32">
					</td>
					<td><?php echo $data['type']; ?></td>
					<td><?php echo $data['count']; ?></td>
				</tr>
				<?php
			} // END foreach($dscanDataOffGrid['data'] as $data)
			?>
		</table>
	</div>
	<?php
} // END if(!empty($shipTypeList))
