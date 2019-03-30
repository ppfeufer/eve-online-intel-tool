<?php
/**
 * Template Name: EVE Intel
 */

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
use \WordPress\Plugins\EveOnlineIntelTool\Libs\IntelParser;

/* @var $templateHelper TemplateHelper */
$templateHelper = TemplateHelper::getInstance();

$serverRequest = \filter_input(\INPUT_SERVER, 'REQUEST_METHOD');
$formAction = \filter_input(\INPUT_POST, 'action');
$showAction = \filter_input(INPUT_GET, 'show');

/**
 * Do something funny with the form input ...
 */
$failedIntel = false;
if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel') {
    $parsedIntel = new IntelParser;

    if($parsedIntel->postID !== null) {
        $link = \get_permalink($parsedIntel->postID);

        \wp_redirect($link);
    }

    $failedIntel = true;
}

\get_header();
?>

<div class="container main template-page-intel">
    <div class="main-content clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
            <div class="content content-inner content-full-width content-page content-page-intel">
                <?php
                switch($showAction) {
                    case 'esiStatus':
                        $templateHelper->getTemplate('partials/index/esi-status');
                        break;

                    default:
                        $templateHelper->getTemplate('partials/index/intel-index', [
                            'failedIntel' => $failedIntel
                        ]);
                        break;
                }
                ?>
            </div> <!-- /.content -->
        </div> <!-- /.col -->
    </div> <!--/.row -->
</div><!-- /.container -->

<?php
\get_footer();
