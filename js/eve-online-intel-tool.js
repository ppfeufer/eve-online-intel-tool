/* global Clipboard, eveIntelToolL10n */

jQuery(document).ready(function($) {
	/**
	 * Remove copy buttons if the browser doesn't support it
	 */
	if(!Clipboard.isSupported()) {
		$('.eve-intel-copy-to-clipboard').remove();
	} // END if(!Clipboard.isSupported())

	function closeCopyMessageElement(element) {
		/**
		 * close after 5 seconds
		 */
		$(element).fadeTo(2000, 500).slideUp(500, function() {
			$(this).slideUp(500, function() {
				$(this).remove();
			});
		});
	} // END function closeCopyMessageElement(element)

	/**
	 * Show message when copy action was successfull
	 *
	 * @param {string} message
	 * @param {string} element
	 * @returns {undefined}
	 */
	function showSuccess(message, element) {
		$(element).html('<div class="alert alert-success alert-dismissable alert-copy-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + message + '</div>');

		closeCopyMessageElement('.alert-copy-success');

		return;
	} // END function showSuccess(message, element)

	/**
	 * Show message when copy action was not successfull
	 *
	 * @param {string} message
	 * @param {string} element
	 * @returns {undefined}
	 */
	function showError(message, element) {
		$(element).html('<div class="alert alert-danger alert-dismissable alert-copy-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + message + '</div>');

		closeCopyMessageElement('.alert-copy-error');

		return;
	} // END function showError(message, element)

	/**
	 * Copy permalink to clipboard
	 */
	$('.btn-copy-permalink-to-clipboard').on('click', function() {
		/**
		 * Copy permalink fitting to clipboard
		 *
		 * @type Clipboard
		 */
		var clipboardPermalinkData = new Clipboard('.btn-copy-permalink-to-clipboard');

		/**
		 * Copy success
		 *
		 * @param {type} e
		 */
		clipboardPermalinkData.on('success', function(e) {
			showSuccess(eveIntelToolL10n.copyToClipboard.permalink.text.success, '.eve-intel-copy-result');

			e.clearSelection();
			clipboardPermalinkData.destroy();
		});

		/**
		 * Copy error
		 */
		clipboardPermalinkData.on('error', function() {
			showError(eveIntelToolL10n.copyToClipboard.permalink.text.error, '.eve-intel-copy-result');

			clipboardPermalinkData.destroy();
		});
	});

	$('.table-local-scan-pilots table').DataTable({
//		'paging': false,
//		'info': false
	});
});
