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
<div class="eve-intel-copy-to-clipboard copy-permalink-to-clipboard">
    <ul class="nav nav-pills clearfix">
        <li role="presentation">
            <a href="<?php echo \get_post_type_archive_link('intel'); ?>"><span type="button" class="btn btn-default"><?php echo \__('New Scan', 'eve-online-intel-tool'); ?></span></a>
        </li>
        <li role="presentation">
            <span type="button" class="btn btn-default btn-copy-permalink-to-clipboard" data-clipboard-action="copy" data-clipboard-text="<?php echo \get_the_permalink(); ?>"><?php echo \__('Copy Permalink', 'eve-online-intel-tool'); ?></span>
        </li>
    </ul>
</div>
<div class="eve-intel-copy-result"></div>
