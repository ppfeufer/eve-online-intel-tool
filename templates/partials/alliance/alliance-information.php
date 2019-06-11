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
<span class="eve-intel-alliance-information-wrapper">
    <span class="eve-intel-alliance-name-wrapper">
        <?php echo $data['allianceName']; ?>
    </span>
    <?php
    if($data['allianceID'] !== 0) {
        ?>
        <span class="eve-intel-alliance-links-wrapper">
            <small><a class="eve-intel-information-link" href="https://evemaps.dotlan.net/alliance/<?php echo \str_replace(' ', '_', $data['allianceName']); ?>" target="_blank" rel="noopener noreferer">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/alliance/<?php echo $data['allianceID']; ?>/" target="_blank" rel="noopener noreferer">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a></small>
        </span>
        <?php
    }
    ?>
</span>
