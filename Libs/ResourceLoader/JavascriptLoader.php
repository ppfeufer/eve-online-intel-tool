<?php
/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\ResourceLoader;

\defined('ABSPATH') or die();

/**
 * JavaScript Loader
 */
class JavascriptLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface {
	/**
	 * Plugin Helper
	 *
	 * @var \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper
	 */
	private $pluginHelper = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->pluginHelper = \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance();
	} // public function __construct()

	/**
	 * Initialize the loader
	 */
	public function init() {
		\add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
	} // public function init()

	/**
	 * Load the JavaScript
	 */
	public function enqueue() {
		/**
		 * Only in Frontend
		 */
		if(!\is_admin()) {
			if(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::isPostTypePage() === true) {
				\wp_enqueue_script('bootstrap-js', $this->pluginHelper->getPluginUri('bootstrap/js/bootstrap.min.js'), ['jquery'], '', true);
				\wp_enqueue_script('bootstrap-toolkit-js', $this->pluginHelper->getPluginUri('bootstrap/bootstrap-toolkit/bootstrap-toolkit.min.js'), ['jquery', 'bootstrap-js'], '', true);

				\wp_enqueue_script('copy-to-clipboard-js', $this->pluginHelper->getPluginUri('js/copy-to-clipboard.min.js'), ['jquery'], '', true);

				\wp_enqueue_script('data-tables-js', $this->pluginHelper->getPluginUri('js/data-tables/jquery.dataTables.min.js'), ['jquery'], '', true);
				\wp_enqueue_script('data-tables-bootstrap-js', $this->pluginHelper->getPluginUri('js/data-tables/dataTables.bootstrap.min.js'), ['jquery', 'data-tables-js'], '', true);

				\wp_enqueue_script('eve-online-intel-tool-js', $this->pluginHelper->getPluginUri('js/eve-online-intel-tool.min.js'), ['jquery'], '', true);
				\wp_localize_script('eve-online-intel-tool-js', 'eveIntelToolL10n', $this->getJavaScriptTranslations());
			} // if(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::isPostTypePage() === true)
		} // if(!\is_admin())
	} // public function enqueue()

	/**
	 * Getting teh translation array to translate strings in JavaScript
	 *
	 * @return array
	 */
	private function getJavaScriptTranslations() {
		return [
			'copyToClipboard' => [
				'permalink' => [
					'text' => [
						'success' => \__('Permalink successfully copied', 'eve-online-intel-tool'),
						'error' => \__('Something went wrong. Nothing copied. Maybe your browser doesn\'t support this function.', 'eve-online-intel-tool')
					]
				]
			],
			'dataTables' => [
				'translation' => [
					'decimal' => \__(',', 'eve-online-intel-tool'),
					'thousands' => \__('.', 'eve-online-intel-tool'),
					'emptyTable' => \__('No data available in table', 'eve-online-intel-tool'),
					'info' => \__('Showing _END_ entries', 'eve-online-intel-tool'),
					'infoEmpty' => \__('No records available', 'eve-online-intel-tool'),
					'infoFiltered' => \__('(filtered from _MAX_ total entries)', 'eve-online-intel-tool'),
					'infoPostFix'  => \__('', 'eve-online-intel-tool'),
					'lengthMenu' => \__('Show _MENU_', 'eve-online-intel-tool'),
					'loadingRecords' => \__('Loading...', 'eve-online-intel-tool'),
					'processing' => \__('Processing...', 'eve-online-intel-tool'),
					'zeroRecords' => \__('Nothing found - sorry', 'eve-online-intel-tool'),
					'search' => \__('_INPUT_', 'eve-online-intel-tool'),
					'searchPlaceholder' => \__('Search...', 'eve-online-intel-tool'),
					'paginate' => [
						'first' => \__('First', 'eve-online-intel-tool'),
						'last' => \__('Last', 'eve-online-intel-tool'),
						'next' => \__('Next', 'eve-online-intel-tool'),
						'previous' => \__('Previous', 'eve-online-intel-tool'),
					],
					'aria' => [
						'sortAscending' => \__(': activate to sort column ascending', 'eve-online-intel-tool'),
						'sortDescending' => \__(': activate to sort column descending', 'eve-online-intel-tool'),
					]
				]
			],
			'ajax' => [
				'url' => \admin_url('admin-ajax.php'),
				'loaderImage' => $this->pluginHelper->getPluginUri('images/loader-sprite.gif')
			]
		];
	} // private function getJavaScriptTranslations()
} // class JavascriptLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface
