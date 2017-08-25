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
	 * Initialize the loader
	 */
	public function init() {
		\add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
	} // END public function init()

	/**
	 * Load the JavaScript
	 */
	public function enqueue() {
		/**
		 * Only in Frontend
		 */
		if(!\is_admin()) {
			if(\is_page(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::getPosttypeSlug('intel')) || \get_post_type() === 'intel') {
				\wp_enqueue_script('bootstrap-js', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('bootstrap/js/bootstrap.min.js'), ['jquery'], '', true);
				\wp_enqueue_script('bootstrap-toolkit-js', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('bootstrap/bootstrap-toolkit/bootstrap-toolkit.min.js'), ['jquery', 'bootstrap-js'], '', true);
				\wp_enqueue_script('bootstrap-gallery-js', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('js/jquery.bootstrap-gallery.min.js'), ['jquery', 'bootstrap-js'], '', true);
				\wp_enqueue_script('copy-to-clipboard-js', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('js/copy-to-clipboard.min.js'), ['jquery'], '', true);
//				\wp_enqueue_script('eve-online-intel-tool-js', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('js/eve-online-fitting-manager.min.js'), ['jquery'], '', true);
//				\wp_localize_script('eve-online-fitting-manager-js', 'fittingManagerL10n', $this->getJavaScriptTranslations());
			} // END if(\is_page(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::getPosttypeSlug('fittings')) || \get_post_type() === 'fitting')
		} // END if(!\is_admin())
	} // END public function enqueue()

	/**
	 * Getting teh translation array to translate strings in JavaScript
	 *
	 * @return array
	 */
	private function getJavaScriptTranslations() {
		return [
			'copyToClipboard' => [
				'eft' => [
					'text' => [
						'success' => \__('EFT data successfully copied', 'eve-online-fitting-manager'),
						'error' => \__('Something went wrong. Nothing copied. Maybe your browser doesn\'t support this function.', 'eve-online-fitting-manager')
					]
				],
				'permalink' => [
					'text' => [
						'success' => \__('Permalink successfully copied', 'eve-online-fitting-manager'),
						'error' => \__('Something went wrong. Nothing copied. Maybe your browser doesn\'t support this function.', 'eve-online-fitting-manager')
					]
				]
			],
			'ajax' => [
				'url' => \admin_url('admin-ajax.php'),
				'loaderImage' => \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getPluginUri('images/loader-sprite.gif')
			]
		];
	} // END private function getJavaScriptTranslations()
} // END class JavascriptLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface
