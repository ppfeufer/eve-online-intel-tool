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

/**
 * Managing the custom post type
 */
class PostType {
	/**
	 * Constructor
	 */
	public function __construct() {
		\add_action('init', [$this, 'customPostType']);

		\add_filter('template_include', [$this, 'templateLoader']);
		\add_filter('page_template', [$this, 'registerPageTemplate']);

		\add_filter('post_type_link', [$this, 'createPermalinks'], 1, 2);
	} // END public function __construct()

	/**
	 * Registering the custom post type
	 */
	public function customPostType() {
		$cptSlug = self::getPosttypeSlug('intel');

		$argsTaxonomyCategory = [
			'label' => \__('Category', 'eve-online-intel-tool'),
//			'labels' => $labelsShip,
			'public' => false,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_in_menu' => false,
			'args' => [
				'orderby' => 'term_order'
			],
			'rewrite' => [
				'slug' => 'intel',
				'with_front' => false
			],
			'query_var' => true
		];

		\register_taxonomy('intel_category', ['intel'], $argsTaxonomyCategory);

		\register_post_type('intel', [
			'labels' => [
				'name' => \__('Intel', 'eve-online-intel-tool'),
				'singular_name' => \__('Intel', 'eve-online-intel-tool')
			],
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'supports' => [
				'title',
				'custom-fields',
				'category'
			],
			'rewrite' => [
				'slug' => $cptSlug . '/%intel_category%',
				'with_front' => true
			],
			'has_archive' => 'intel'
		]);

		// Adding our default categories ...
		\wp_insert_term('D-Scan', 'intel_category', [
			'slug' => 'dscan'
		]);
		\wp_insert_term('Local Scan', 'intel_category', [
			'slug' => 'local'
		]);
	} // END public function customPostType()

	public function createPermalinks($post_link, $post) {
		if(\is_object($post) && $post->post_type === 'intel') {
			$terms = \wp_get_object_terms($post->ID, 'intel_category');

			if($terms) {
				return \str_replace('%intel_category%' , $terms[0]->slug , $post_link);
			} // END if($terms)
		} // END if(\is_object($post) && $post->post_type === 'intel')

		return $post_link;
	} // END public function createPermalinks($post_link, $post)

	/**
	 * Getting the slug for the custom post type
	 *
	 * If the pages for looping the custom post types have not the same name
	 * as the custom post type, we need to find its slug to get it working.
	 *
	 * @param string $postType
	 */
	public static function getPosttypeSlug($postType) {
		global $wpdb;

		$var_qry = '
			SELECT
				' . $wpdb->posts . '.post_name as post_name
			FROM
				' . $wpdb->posts . ',
				' . $wpdb->postmeta . '
			WHERE
				' . $wpdb->postmeta . '.meta_key = "_wp_page_template"
				AND ' . $wpdb->postmeta . '.meta_value = "../templates/page-' . $postType . '.php"
				AND ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id;';

		$slugData = $wpdb->get_var($var_qry);

		/**
		 * Returning the slug or, if not found the name of custom post type
		 */
		if(!empty($slugData)) {
			return $slugData;
		} else {
			return $postType;
		} // END if(!empty($var_sSlugData))
	} // END private function _getPosttypeSlug($var_sPosttype)

	/**
	 * Template loader.
	 *
	 * The template loader will check if WP is loading a template
	 * for a specific Post Type and will try to load the template
	 * from out 'templates' directory.
	 *
	 * @since 1.0.0
	 *
	 * @param	string	$template	Template file that is being loaded.
	 * @return	string				Template file that should be loaded.
	 */
	public function templateLoader($template) {
		$templateFile = null;

		if(\is_singular('intel')) {
			$templateFile = 'single-intel.php';
		} elseif(\is_archive() && \get_post_type() === 'intel') {
			$templateFile = 'page-intel.php';
		} // END if(\is_singular('fitting'))

		if($templateFile !== null) {
			if(\file_exists(Helper\TemplateHelper::locateTemplate($templateFile))) {
				$template = Helper\TemplateHelper::locateTemplate($templateFile);
			} // END if(\file_exists(Helper\TemplateHelper::locateTemplate($file)))
		} // END if($templateFile !== null)

		return $template;
	} // END function templateLoader($template)

	/**
	 * Registering a page template
	 *
	 * @param string $pageTemplate
	 * @return string
	 */
	public function registerPageTemplate($pageTemplate) {
		if(\is_page(self::getPosttypeSlug('intel'))) {
			$pageTemplate = Helper\PluginHelper::getPluginPath('templates/page-intel.php');
		} // END if(\is_page($this->getPosttypeSlug('intel')))

		return $pageTemplate;
	} // END public function registerPageTemplate($pageTemplate)
} // END class PostType
