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

$characterPortrait = ImageHelper::getInstance()->getImageServerUrl('character') . $data['characterID'] . '_32.jpg';
?>

<span class="eve-intel-pilot-avatar-wrapper"><img class="eve-image" data-eveid="<?php echo $data['characterID']; ?>" src="<?php echo $characterPortrait; ?>" alt="<?php echo $data['characterName']; ?>" width="32" heigh="32"></span>
