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

?>
<span class="eve-intel-pilot-information-wrapper">
    <span class="eve-intel-pilot-name-wrapper">
        <?php echo $data['characterName']; ?>
    </span>
    <span class="eve-intel-pilot-links-wrapper">
        <small><a class="eve-intel-information-link" href="https://evewho.com/pilot/<?php echo \urlencode($data['characterName']); ?>" target="_blank" rel="noopener noreferer">evewho <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/character/<?php echo $data['characterID']; ?>/" target="_blank" rel="noopener noreferer">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
    </span>
</span>
