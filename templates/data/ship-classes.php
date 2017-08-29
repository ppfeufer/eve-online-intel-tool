<header class="entry-header"><h2 class="entry-title"><?php echo \__('Ship Classes', 'eve-online-intel-tool'); ?></h2></header>
<?php
if(\is_array($shipClassList) && \count($shipClassList) > 0) {
	?>
	<div class="table-responsive table-eve-intel-shipclasses table-eve-intel">
		<table class="table table-condensed">
			<?php
			foreach($shipClassList as $data) {
				?>
				<tr data-typeclass="<?php echo $data['shipTypeSanitized']; ?>" onmouseover="dscanHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');" onmouseout="dscanDisableHighlightShipClass('<?php echo $data['shipTypeSanitized']; ?>');">
					<td>
						<?php
						$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('ship') . $data['shipID'] . '_32.png');
						?>
						<img src="<?php echo $image; ?>" alt="<?php echo $data['shipName']; ?>" width="32" heigh="32">
						<?php echo $data['shipName']; ?>
					</td>
					<td>
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
