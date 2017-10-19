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
	} // END if($parsedIntel->postID !== null)

	$failedIntel = true;
} // END if($serverRequest === 'POST' && !empty($formAction) && $formAction === 'new_intel')

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
								?>
								<div class="bs-callout bs-callout-warning intel-parse-error">
									<p class="small"><?php echo \__('The provided data could not be parsed. Please check and try again.', 'eve-online-intel-tool'); ?></p>
								</div>
								<?php
							}
							?>

							<div class="paste-explanation">
								<header class="entry-header"><h2 class="entry-title"><?php echo \__('What can I paste?', 'eve-online-intel-tool'); ?></h2></header>
								<ul>
									<li>» <?php echo \__('D-Scan', 'eve-online-intel-tool'); ?></li>
									<li>» <?php echo \__('Chat Memberlist', 'eve-online-intel-tool'); ?> <small><?php echo \__('(takes some time to parse)', 'eve-online-intel-tool'); ?></small></li>
									<li>» <?php echo \__('Fleet Composition', 'eve-online-intel-tool'); ?> <small><?php echo \__('(takes some time to parse)', 'eve-online-intel-tool'); ?></small></li>
								</ul>
							</div>

							<div class="bs-callout bs-callout-info">
								<p class="small"><?php echo \sprintf(\__('This tool is still in its testing phase, so it might have some hiccups and rough edges here and there. If you experience any odd behaviour, please let me know about it in the %1$s.', 'eve-online-intel-tool'), '<a href="' .\esc_url('https://github.com/ppfeufer/eve-online-intel-tool/issues') . '" rel="external">' . \__('Github Issue Tracker', '') . '</a>'); ?></p>
								<p class="small"><?php echo \__('Thank you!', 'eve-online-intel-tool'); ?></p>
							</div>
						</div>
						<div class="col-lg-8">
							<form id="new_intel" name="new_intel" method="post">
								<div class="form-group">
									<textarea class="form-control" rows="15" id="eveIntel" name="eveIntel" placeholder="<?php echo \__('Paste here ...', 'eve-online-intel-tool'); ?>"></textarea>
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
						</div>
					</div>
				</article>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- /.container -->

<?php \get_footer(); ?>
