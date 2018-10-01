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

\defined('ABSPATH') or die();
?>

<header class="page-title">
    <h1><?php echo \__('Unknown Data Provided', 'eve-online-intel-tool'); ?></h1>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-unknown'); ?>>
    <section class="post-content">
        <div class="entry-content">
            <div class="dscan-result row">
                <p><?php echo \__('You provided an unknown type of data, so it could not be parsed. Sorry!', 'eve-online-intel-tool'); ?></p>
            </div>
        </div>
    </section>
</article><!-- /.post-->
