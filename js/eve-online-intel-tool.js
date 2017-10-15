/* global Clipboard, eveIntelToolL10n, eveImages */

jQuery(document).ready(function($) {
	/**
	 * Remove copy buttons if the browser doesn't support it
	 */
	if(!Clipboard.isSupported()) {
		$('.eve-intel-copy-to-clipboard').remove();
	} // if(!Clipboard.isSupported())

	/**
	 * Closing the message
	 *
	 * @param {string} element
	 * @returns {void}
	 */
	function closeCopyMessageElement(element) {
		/**
		 * close after 5 seconds
		 */
		$(element).fadeTo(2000, 500).slideUp(500, function() {
			$(this).slideUp(500, function() {
				$(this).remove();
			});
		});
	} // function closeCopyMessageElement(element)

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
	} // function showSuccess(message, element)

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
	} // function showError(message, element)

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
		if(typeof($(this).data('haspaging')) !== 'undefined' && $(this).data('haspaging') === 'no') {
			$($(this)).DataTable({
				language: eveIntelToolL10n.dataTables.translation,
				paging: false,
				dom:
					'<\'row\'<\'col-sm-12\'f>>' +
					'<\'row\'<\'col-sm-12\'tr>>' +
					'<\'row\'<\'col-sm-12\'i>>'
			});
		} else {
			$($(this)).DataTable({
				language: eveIntelToolL10n.dataTables.translation
			});
		} // if(typeof($(this).data('haspaging')) !== 'undefined' && $(this).data('haspaging') === 'no')
	});

	/**
	 * Highlighting similar table rows on mouse over
	 */
	$('tr[data-highlight]').hover(function() {
		$('tr[data-highlight="' + $(this).data('highlight') + '"]').toggleClass('dataHighlight');
	});

	/**
	 * Sticky highlight similar table rows on click
	 *
	 * todo:
	 * Get this to work with data tables pagination, so it's deactivated for now
	 */
//	$('tr[data-highlight]').click(function() {
//		$('tr[data-highlight="' + $(this).data('highlight') + '"]').toggleClass('dataHighlightSticky');
//	});

	/**
	 * Getting the nonce for the form
	 * Have to do it this way, because of possible static caches that might be used
	 */
	if($('form#new_intel').length) {
		/**
		 * Ajax Call: get-eve-intel-form-nonce
		 */
		var getEveIntelFormNonce = {
			ajaxCall: function() {
				$.ajax({
					type: 'post',
					url: eveIntelToolL10n.ajax.url,
					data: 'action=get-eve-intel-form-nonce',
					dataType: 'json',
					success: function(result) {
						if(result !== null) {
							// Setting the nonce
							$('#_wpnonce').val(result);

							// Enabling the button
							$('button[name="submit-form"]').removeAttr('disabled').button('refresh');

							// Removing loader animation
							$('.authenticating-form').remove();
						} // END if(result !== null)
					},
					error: function(jqXHR, textStatus, errorThrow) {
						console.log('Ajax request - ' + textStatus + ': ' + errorThrow);
					}
				});
			}
		};

		/**
		 * Call the ajax to get the nonce
		 */
		getEveIntelFormNonce.ajaxCall();
	} // if($('form#new_intel').length)


	/**
	 * If lazy loading for EVE images is activated ....
	 */
	if($('.eve-intel-result').length) {
		/**
		 * Ajax Call: get-eve-intel-entity-image
		 */
		var getEveIntelEntityImage = {
			ajaxCall: function(data) {
				$.ajax({
					type: 'post',
					url: eveIntelToolL10n.ajax.url,
					data: 'action=get-eve-intel-entity-image&entityType=' + data.entityType + '&entityID=' + data.eveID + '&imageUri=' + data.imageUri,
					dataType: 'json',
					success: function(result) {
						if(result !== null) {
							$('img[data-eveid="' + data.eveID + '"]').attr('src', result);
						} // END if(result !== null)
					},
					error: function(jqXHR, textStatus, errorThrow) {
						console.log('Ajax request - ' + textStatus + ': ' + errorThrow);
					}
				});
			}
		};

		/**
		 * Call the ajax to get the entity image
		 */
		if(typeof eveImages !== 'undefined') {
			$(eveImages).each(function() {
				getEveIntelEntityImage.ajaxCall($(this)[0]);
			});
		} // if(typeof eveImages !== 'undefined')
	} // if($('.eve-intel-result').length)

	var cSpeed = 5;
	var cWidth = 127;
	var cHeight = 19;
	var cTotalFrames = 20;
	var cFrameWidth = 127;
	var cImageSrc = eveIntelToolL10n.ajax.loaderImage;

	var cImageTimeout = false;
	var cIndex = 0;
	var cXpos = 0;
	var cPreloaderTimeout = false;
	var SECONDS_BETWEEN_FRAMES = 0;

	/**
	 * Continue animation
	 *
	 * @returns {undefined}
	 */
	var continueAnimation = function() {
		cXpos += cFrameWidth;

		/**
		 * increase the index so we know which frame
		 * of our animation we are currently on
		 */
		cIndex += 1;

		/**
		 * if our cIndex is higher than our total number of frames,
		 * we're at the end and should restart
		 */
		if(cIndex >= cTotalFrames) {
			cXpos = 0;
			cIndex = 0;
		} // if(cIndex >= cTotalFrames)

		if($('#new_intel .loaderImage')) {
			$('#new_intel .loaderImage').css('backgroundPosition', (-cXpos) + 'px 0');
		} // if($('#new_intel .loaderImage'))

		cPreloaderTimeout = setTimeout(continueAnimation, SECONDS_BETWEEN_FRAMES * 1000);
	};

	/**
	 * Start animation
	 *
	 * @returns {undefined}
	 */
	var startAnimation = function() {
		$('#new_intel .loaderImage').css('display', 'block');
		$('#new_intel .loaderImage').css('backgroundImage', 'url(' + cImageSrc + ')');
		$('#new_intel .loaderImage').css('width', cWidth + 'px');
		$('#new_intel .loaderImage').css('height', cHeight + 'px');

		var FPS = Math.round(100 / cSpeed);
		SECONDS_BETWEEN_FRAMES = 1 / FPS;

		cPreloaderTimeout = setTimeout(continueAnimation, SECONDS_BETWEEN_FRAMES / 1000);
	};

	/**
	 * stops animation
	 *
	 * @returns {undefined}
	 */
	var stopAnimation = function() {
		clearTimeout(cPreloaderTimeout);
		cPreloaderTimeout = false;
	};

	/**
	 * Imageloader
	 *
	 * @param {type} s
	 * @param {type} fun
	 * @returns {undefined}
	 */
	var imageLoader = function(s, fun) {
		clearTimeout(cImageTimeout);
		cImageTimeout = 0;

		var genImage = new Image();

		genImage.onload = function() {
			cImageTimeout = setTimeout(fun, 0);
		};

		genImage.onerror = new Function('alert(\'Could not load the image\')');
		genImage.src = s;
	};

	/**
	 * Start the animation
	 */
	imageLoader(cImageSrc, startAnimation);
});

/* Common functions
 * -------------------------------------------------------------------------- */
function inArray(needle, haystack) {
	var length = haystack.length;

	for(var i = 0; i < length; i++) {
		if(haystack[i] === needle) return true;
	} // for(var i = 0; i < length; i++)

	return false;
} // function inArray(needle, haystack)
