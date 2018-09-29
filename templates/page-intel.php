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

$serverRequest = \filter_input(\INPUT_SERVER, 'REQUEST_METHOD');
$formAction = \filter_input(\INPUT_POST, 'action');

$failedIntel = false;
if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel') {
    $parsedIntel = new \WordPress\Plugins\EveOnlineIntelTool\Libs\IntelParser;

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
                                \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/parse-error');
                            }

                            \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/intel-form-explanation');
                            ?>
                        </div>
                        <div class="col-lg-8">
                            <?php
                            \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/intel-form');
                            ?>
                        </div>
                    </div>
                </article>
            </div> <!-- /.content -->
        </div> <!-- /.col -->
    </div> <!--/.row -->
</div><!-- /.container -->

<?php
\get_footer();
