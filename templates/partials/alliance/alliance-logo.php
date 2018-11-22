<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\ImageHelper;

$allianceLogo = (isset($data['allianceLogo']) && !is_null($data['allianceLogo'])) ? $data['allianceLogo'] : ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png';

$size = 32;
if(isset($data['size'])) {
    $size = $data['size'];
}
?>

<span class="eve-intel-alliance-logo-wrapper"><img class="eve-image" data-eveid="<?php echo $data['allianceID']; ?>" src="<?php echo $allianceLogo; ?>" alt="<?php echo $data['allianceName']; ?>" title="<?php echo $data['allianceName']; ?>" width="<?php echo $size; ?>" heigh="<?php echo $size; ?>"></span>
