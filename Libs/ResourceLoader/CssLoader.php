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
 * CSS Loader
 */
class CssLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface {
	/**
	 * Initialize the loader
	 */
	public function init() {
		\add_action('wp_enqueue_scripts', [$this, 'enqueue'], 99);
	} // END public function init()

	/**
	 * Load the styles
	 */
	public function enqueue() {
		/**
		 * Only in Frontend
		 */
		if(!\is_admin()) {
			/**
			 * load only when needed
			 */
			if(\is_page(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::getPosttypeSlug('intel')) || \get_post_type() === 'intel' || \is_post_type_archive('intel') === true) {
				\wp_enqueue_style('bootstrap', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('bootstrap/css/bootstrap.min.css'));
				\wp_enqueue_style('data-tables-bootstrap', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('css/data-tables/dataTables.bootstrap.min.css'));
				\wp_enqueue_style('eve-online-intel-tool', \WordPress\Plugin\EveOnlineIntelTool\Libs\Helper\PluginHelper::getInstance()->getPluginUri('css/eve-online-intel-tool.min.css'));
			} // END if(\is_page(\WordPress\Plugin\EveOnlineIntelTool\Libs\PostType::getPosttypeSlug('fittings')) || \get_post_type() === 'fitting')
		} // END if(!\is_admin())
	} // END public function enqueue()
} // END class CssLoader implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface
