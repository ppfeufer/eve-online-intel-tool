<?php
/**
 * Template Name: EVE Intel
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
			<div class="content content-inner content-full-width content-page content-page-intel">
				<header>
					<h1><?php echo \__('Intel Parser', 'eve-online-intel-tool'); ?></h1>
				</header>
				<article class="post clearfix">
					<p>
						<?php echo \__('Please keep in mind, that parsing large amount of data can take some time. Be patient, CCP\'s API is not the fastest to answer ....', 'eve-online-intel-tool'); ?>
					</p>
					<div class="row">
						<div class="col-lg-4 paste-explanation">
							<header class="entry-header"><h2 class="entry-title">What can I paste?</h2></header>
							<ul>
								<li>» D-Scan</li>
								<li>» Chat Memberlist <small>(takes some time to parse)</small></li>
								<li>» Fleet Composition <small>(Well, not yet, still working on that one ...)</small></li>
							</ul>
						</div>
						<div class="col-lg-8">
							<form id="new_intel" name="new_intel" method="post">
								<div class="form-group">
									<!--<label for="eveIntel"></label>-->
									<textarea class="form-control" rows="15" id="eveIntel" name="eveIntel" placeholder="Paste here ..."></textarea>
								</div>
								<button type="submit" class="btn btn-default"><?php echo \__('Submit', 'eve-online-intel-tool'); ?></button>

								<input type="hidden" name="action" value="new_intel" />
								<?php // \wp_nonce_field('eve-online-intel-tool-new-intel'); ?>
							</form>
						</div>
					</div>
				</article>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- /.container -->

<?php get_footer(); ?>
