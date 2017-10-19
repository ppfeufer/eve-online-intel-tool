<?php
$image = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getLocalCacheImageUriForRemoteImage('ship', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\ImageHelper::getInstance()->getImageServerUrl('ship') . $data['shipID'] . '_32.png');
?>
<img data-eveid="<?php echo $data['shipID']; ?>" data-shipclass="<?php echo $data['shipName']; ?>" src="<?php echo $image; ?>" alt="<?php echo $data['shipName']; ?>" width="32" heigh="32">
