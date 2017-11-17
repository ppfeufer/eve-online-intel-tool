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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs;

\defined('ABSPATH') or die();

class TemplateLoader {
	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	public function __construct() {
		$this->templates = [];

		// Add a filter to the attributes metabox to inject template into the cache.
		if(\version_compare(\floatval(\get_bloginfo('version')), '4.7', '<')) {
			// 4.6 and older
			\add_filter('page_attributes_dropdown_pages_args', [$this, 'registerProjectTemplates']);
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			\add_filter('theme_page_templates', [$this, 'addNewTemplate']);
		} // if(\version_compare(\floatval(\get_bloginfo('version')), '4.7', '<'))

		// Add a filter to the save post to inject out template into the page cache
		\add_filter('wp_insert_post_data', [$this, 'registerProjectTemplates']);


		// Add a filter to the template include to determine if the page has our
		// template assigned and return it's path
		\add_filter('template_include', [$this, 'viewProjectTemplate']);

		// Add your templates to this array.
		$this->templates = [
			'../templates/page-intel.php' => 'EVE Intel',
		];
	} // private function __construct()

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 * @param array $posts_templates
	 * @return array
	 */
	public function addNewTemplate($posts_templates) {
		$posts_templates = \array_merge($posts_templates, $this->templates);

		return $posts_templates;
	} // public function addNewTemplate($posts_templates)

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 *
	 * @param array $atts
	 * @return array
	 */
	public function registerProjectTemplates($atts) {
		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . \md5(\get_theme_root() . '/' . \get_stylesheet());

		// Retrieve the cache list.
		// If it doesn't exist, or it's empty prepare an array
		$templates = \wp_get_theme()->get_page_templates();

		if(empty($templates)) {
			$templates = [];
		} // if(empty($templates))

		// New cache, therefore remove the old one
		\wp_cache_delete($cache_key, 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = \array_merge($templates, $this->templates);

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		\wp_cache_add($cache_key, $templates, 'themes', 1800);

		return $atts;
	} // public function registerProjectTemplates($atts)

	/**
	 * Checks if the template is assigned to the page
	 *
	 * @global object $post
	 * @param array $template
	 * @return string
	 */
	public function viewProjectTemplate($template) {
		// Get global post
		global $post;

		// Return template if post is empty
		if(!$post) {
			return $template;
		} // if(!$post)

		// Return default template if we don't have a custom one defined
		if(!isset($this->templates[\get_post_meta($post->ID, '_wp_page_template', true)])) {
			return $template;
		} // if(!isset($this->templates[\get_post_meta($post->ID, '_wp_page_template', true)]))

		$file = \plugin_dir_path(__FILE__) . \get_post_meta($post->ID, '_wp_page_template', true);

		// Just to be safe, we check if the file exist first
		if(\file_exists($file)) {
			return $file;
		} else {
			echo $file;
		} // if(\file_exists($file))

		// Return template
		return $template;
	} // public function viewProjectTemplate($template)
} // class TemplateLoader
