<?php
defined('ABSPATH') or die();

// get the intel type
$termObject = \get_the_terms(\get_the_ID(), 'intel_category');
$intelType = 'unknown';

switch($termObject['0']->slug) {
	case 'dscan':
		$intelType = 'dscan';
		break;

	case 'local':
		$intelType = 'local';
		break;

	case 'fleetcomposition':
		$intelType = 'fleetcomposition';
		break;

	default:
		break;
} // END switch($termObject['0']->slug)

// If the jSon format is requested
$getData = \filter_input(INPUT_GET, 'data');
if(isset($getData) && $getData = 'json') {
	\WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('json-api/json-' . $intelType);
} // END if(isset($getData) && $getData = 'json')

\get_header();
?>

<div class="container container-main">
	<!--<div class="row main-content">-->
	<div class="main-content clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-12 content-wrapper">
			<div class="content content-inner content-archive">
				<?php \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\TemplateHelper::getTemplate('single-' . $intelType); ?>
			</div> <!-- /.content -->
		</div> <!-- /.col -->
	</div> <!--/.row -->
</div><!-- container -->

<?php \get_footer(); ?>
