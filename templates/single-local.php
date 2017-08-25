<?php
defined('ABSPATH') or die();
?>

<article id="post-<?php \the_ID(); ?>" <?php \post_class('clearfix content-single template-content-fitting'); ?>>
	<section class="post-content">
		<div class="entry-content">
			<?php
			the_content();
			?>
		</div>
	</section>
</article><!-- /.post-->
