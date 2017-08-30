<?php
defined('ABSPATH') or die();
?>

<header class="page-title">
	<h1>
		<?php echo \__('Unknown Data Provided', 'eve-online-intel-tool'); ?>
	</h1>
</header>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-single-unknown'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<div class="dscan-result row">
				<p><?php echo \__('You provided an unknown type of data, so it could not be parsed. Sorry!', 'eve-online-intel-tool'); ?></p>
			</div>
		</div>
	</section>
</article><!-- /.post-->
