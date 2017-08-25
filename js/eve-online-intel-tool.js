jQuery(document).ready(function($) {
	function dscanHighlightShipClass(shipClass) {
		$("div[data-typeclass='"+shipClass+"']").addClass('highlightShipClass');
	}

	function dscanDisableHighlightShipClass(shipClass) {
		$("div[data-typeclass='"+shipClass+"']").removeClass('highlightShipClass');
	}
});
