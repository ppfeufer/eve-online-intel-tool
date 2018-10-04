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

$imageAlliance = ImageHelper::getInstance()->getImageServerUrl('alliance') . $data['allianceID'] . '_32.png';
?>

<span class="eve-intel-alliance-logo-wrapper"><img class="eve-image" data-eveid="<?php echo $data['allianceID']; ?>" src="<?php echo $imageAlliance; ?>" alt="<?php echo $data['allianceName']; ?>" title="<?php echo $data['allianceName']; ?>" width="32" heigh="32"></span>
