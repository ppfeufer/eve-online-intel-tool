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

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper;

?>

<header>
    <h1><?php echo \__('Intel Parser', 'eve-online-intel-tool'); ?></h1>
</header>
<article class="post clearfix">
    <p>
        <?php echo \__('Please keep in mind, parsing large amount of data can take some time. Be patient, CCP\'s API is not the fastest to answer ....', 'eve-online-intel-tool'); ?>
    </p>
    <div class="row">
        <div class="col-lg-4">
            <?php
            if($failedIntel === true) {
                TemplateHelper::getInstance()->getTemplate('partials/intel-form/parse-error');
            }

            TemplateHelper::getInstance()->getTemplate('partials/intel-form/intel-form-explanation');
            TemplateHelper::getInstance()->getTemplate('partials/intel-form/esi-status');
            ?>
        </div>
        <div class="col-lg-8">
            <?php
            TemplateHelper::getInstance()->getTemplate('partials/intel-form/intel-form');
            ?>
        </div>
    </div>
</article>
