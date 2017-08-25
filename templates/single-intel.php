<?php
defined('ABSPATH') or die();

\get_header();
?>

<div class="container container-main">
	<!--<div class="row main-content">-->
	<div class="main-content clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
			<div class="content content-inner content-archive">
<!--				<header class="page-title">
					<h1>INTEL</h1>
					<?php
					// Show an optional category description
//					$category_description = \category_description();
//					if($category_description) {
//						echo \apply_filters('category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>');
//					} // END if($category_description)
					?>
				</header>-->
				<?php
				if(\have_posts()) {
					while(\have_posts()) {
						\the_post();
						$termObject = \get_the_terms(\get_the_ID(), 'intel_category');

						switch($termObject['0']->slug) {
							case 'dscan':
								\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('single-dscan');
								break;

							case 'local':
								\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('single-local');
								break;
						} // END switch($termObject['0']->slug)

//						\get_template_part('content', \get_post_format());
					} // END while (have_posts())
				} // END if(have_posts())
				?>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- container -->

<?php \get_footer(); ?>
