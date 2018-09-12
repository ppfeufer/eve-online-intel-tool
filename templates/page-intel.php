<?php
/**
 * Template Name: EVE Intel
 */

$serverRequest = \filter_input(\INPUT_SERVER, 'REQUEST_METHOD');
$formAction = \filter_input(\INPUT_POST, 'action');

$failedIntel = false;
if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel') {
    $parsedIntel = new \WordPress\Plugin\EveOnlineIntelTool\Libs\IntelParser;

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
                                \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/parse-error');
                            }

                            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/intel-form-explanation');
                            ?>
                        </div>
                        <div class="col-lg-8">
                            <?php
                            \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('partials/intel-form/intel-form');
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
