<?php
/**
 * Template Name: Intel
 */

$serverRequest = \filter_input(INPUT_SERVER, 'REQUEST_METHOD');
$formAction = \filter_input(INPUT_POST, 'action');

if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel') {
	$parsedIntel = new \WordPress\Plugin\EveOnlineIntelTool\Libs\IntelParser;

	if($parsedIntel->postID !== null) {
		$link = \get_permalink($parsedIntel->postID);

		\wp_redirect($link);
	} // END if($parsedIntel->postID !== null)
} // END if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel')

get_header();
?>

<div class="container main template-page-intel">
	<div class="main-content clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
			<div class="content content-inner content-full-width content-page">
				<header>
					<h1><?php echo \__('Intel', 'eve-online-intel-tool'); ?></h1>
				</header>
				<article class="post clearfix">
					<form id="new_intel" name="new_intel" method="post">
						<div class="form-group">
							<label for="eveIntel"><?php echo \__('Paste your D-Scan here ...', 'eve-online-intel-tool'); ?></label>
							<textarea class="form-control" rows="15" id="eveIntel" name="eveIntel" placeholder="Paste here ..."></textarea>
						</div>
						<button type="submit" class="btn btn-default"><?php echo \__('Submit', 'eve-online-intel-tool'); ?></button>

						<input type="hidden" name="action" value="new_intel" />
						<?php \wp_nonce_field('eve-online-intel-tool-new-intel'); ?>
					</form>
				</article>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- /.container -->

<?php get_footer(); ?>
