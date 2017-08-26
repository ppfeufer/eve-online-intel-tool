<?php
defined('ABSPATH') or die();

\get_header();
?>

<div class="container container-main">
	<!--<div class="row main-content">-->
	<div class="main-content clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
			<div class="content content-inner content-archive">
				<?php
				$termObject = \get_the_terms(\get_the_ID(), 'intel_category');

				switch($termObject['0']->slug) {
					case 'dscan':
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('single-dscan');
						break;

					case 'local':
						\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('single-local');
						break;

					default:
						break;
				} // END switch($termObject['0']->slug)
				?>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- container -->

<?php \get_footer(); ?>
