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

use \WordPress\Plugins\EveOnlineIntelTool\Libs\PostType;

/* @var $postType PostType */
$postType = PostType::getInstance();
$textareaRows = (isset($textareaRows)) ? $textareaRows : 15;
?>

<form id="new_intel" name="new_intel" method="post" action="/<?php echo $postType->getPosttypeSlug('intel'); ?>/">
    <div class="form-group">
        <textarea class="form-control" rows="<?php echo $textareaRows; ?>" id="eveIntel" name="eveIntel" placeholder="<?php echo \__('Paste here ...', 'eve-online-intel-tool'); ?>"></textarea>
    </div>

    <div class="row form-submit-area">
        <div class="col-sm-2">
            <button type="submit" class="btn btn-default" name="submit-form" disabled><?php echo \__('Submit', 'eve-online-intel-tool'); ?></button>
        </div>
        <div class="col-sm-10">
            <span class="authenticating-form">
                <span class="loaderImage"></span>
                <?php echo \__('Waiting for the system to authenticate the form ...', 'eve-online-intel-tool'); ?>
            </span>
        </div>
    </div>

    <input type="hidden" name="action" value="new_intel" />
    <?php \wp_nonce_field('eve-online-intel-tool-new-intel-form'); ?>
</form>
