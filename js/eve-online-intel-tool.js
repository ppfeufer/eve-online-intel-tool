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

	/**
	 * Array of all data tables on the current page
	 *
	 * @type array
	 */
	var dataTables = $('.table-sortable');
	dataTables.each(function() {
		var translation = {
			decimal: eveIntelToolL10n.dataTables.translation.decimal,
			thousands: eveIntelToolL10n.dataTables.translation.thousands,
			emptyTable: eveIntelToolL10n.dataTables.translation.emptyTable,
			info: eveIntelToolL10n.dataTables.translation.info,
			infoEmpty: eveIntelToolL10n.dataTables.translation.infoEmpty,
			infoFiltered: eveIntelToolL10n.dataTables.translation.infoFiltered,
			infoPostFix: eveIntelToolL10n.dataTables.translation.infoPostFix,
			lengthMenu: eveIntelToolL10n.dataTables.translation.lengthMenu,
			loadingRecords: eveIntelToolL10n.dataTables.translation.loadingRecords,
			processing: eveIntelToolL10n.dataTables.translation.processing,
			zeroRecords: eveIntelToolL10n.dataTables.translation.zeroRecords,
			search: eveIntelToolL10n.dataTables.translation.search,
			searchPlaceholder: eveIntelToolL10n.dataTables.translation.searchPlaceholder,
			paginate: {
				first: eveIntelToolL10n.dataTables.translation.paginate.first,
				last: eveIntelToolL10n.dataTables.translation.paginate.last,
				next: eveIntelToolL10n.dataTables.translation.paginate.next,
				previous: eveIntelToolL10n.dataTables.translation.paginate.previous
			},
			aria: {
				sortAscending: eveIntelToolL10n.dataTables.translation.paginate.sortAscending,
				sortDescending: eveIntelToolL10n.dataTables.translation.paginate.sortDescending
			}
		};

		if(typeof($(this).data('haspaging')) !== 'undefined' && $(this).data('haspaging') === 'no') {
			$($(this)).DataTable({
				language: translation,
				paging: false,
				dom:
					'<\'row\'<\'col-sm-12\'f>>' +
					'<\'row\'<\'col-sm-12\'tr>>' +
					'<\'row\'<\'col-sm-12\'i>>',
			});
		} else {
			$($(this)).DataTable({
				language: translation
			});
		} // END if(typeof($(this).data('haspaging')) !== 'undefined' && $(this).data('haspaging') === 'no')
	});

	/**
	 * Highlighting similar table rows on mouse over
	 */
	$('tr[data-highlight]').hover(function() {
		$('tr[data-highlight="' + $(this).data('highlight') + '"]').toggleClass('dataHighlight');
	});

	/**
	 * Sticky highlight similar table rows on click
	 */
	$('tr[data-highlight]').click(function() {
		$('tr[data-highlight="' + $(this).data('highlight') + '"]').toggleClass('dataHighlightSticky');
	});
});
