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
<span class="eve-intel-corporation-information-wrapper">
    <span class="eve-intel-corporation-name-wrapper">
        <?php echo $data['corporationName']; ?>
    </span>

    <span class="eve-intel-corporation-links-wrapper">
        <small>
            <?php
            /**
             * See if we have a NPC corp or a player corp
             *
             * @see https://gist.github.com/a-tal/5ff5199fdbeb745b77cb633b7f4400bb
             */
            if((1000000 <= $data['corporationID']) && $data['corporationID'] <= 2000000) {
                echo \__('(NPC Corp)', 'eve-online-intel-tool');
            } else {
                ?>
                <a class="eve-intel-information-link" href="https://evemaps.dotlan.net/corp/<?php echo \str_replace(' ', '_', $data['corporationName']); ?>" target="_blank">dotlan <i class="fa fa-external-link" aria-hidden="true"></i></a> | <a class="eve-intel-information-link" href="https://zkillboard.com/corporation/<?php echo $data['corporationID']; ?>/" target="_blank">zkillboard <i class="fa fa-external-link" aria-hidden="true"></i></a>
                <?php
            }
            ?>
        </small>
    </span>
</span>
