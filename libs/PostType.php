<?php

namespace WordPress\Plugin\EveOnlineDscanTool\Libs;

use WordPress\Plugin\EveOnlineDscanTool;

\defined('ABSPATH') or die();

class PostType {
	public function __construct() {
		\add_action('init', array($this, 'customPostType'));

		\add_filter('template_include', array($this, 'templateLoader'));
	} // END public function __construct()

	public function customPostType() {
		$var_sSlug = $this->_getPosttypeSlug('dscan');

//		$array_Labels = array(
//			'name' => \__('Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'singular_name' => \__('Fitting Category', 'eve-online-dscan-tool-for-wordpress'),
//			'search_items' => \__('Search Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'popular_items' => \__('Popular Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'all_items' => \__('All Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'parent_item' => \__('Parent Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'edit_item' => \__('Edit Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'update_item' => \__('Update Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'add_new_item' => \__('Add New Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'new_item_name' => \__('New Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'separate_items_with_commas' => \__('Separate Fitting Categories with commas', 'eve-online-dscan-tool-for-wordpress'),
//			'add_or_remove_items' => \__('Add or remove Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'choose_from_most_used' => \__('Choose from most used Fitting Categories', 'eve-online-dscan-tool-for-wordpress')
//		);

//		$array_Args = array(
//			'label' => \__('Fitting Categories', 'eve-online-dscan-tool-for-wordpress'),
//			'labels' => $array_Labels,
//			'public' => true,
//			'hierarchical' => true,
//			'show_ui' => true,
//			'show_in_nav_menus' => true,
//			'args' => array(
//				'orderby' => 'term_order'
//			),
//			'rewrite' => array(
//				'slug' => $var_sSlug . '/doctrine',
//				'with_front' => true
//			),
//			'query_var' => true
//		);

//		register_taxonomy('fitting-categories', array(
//			'fitting'
//			),
//			$array_Args
//		);

		\register_post_type('dscan', array(
			'labels' => array(
				'name' => \__('Dscans', 'eve-online-dscan-tool-for-wordpress'),
				'singular_name' => \__('Dscan', 'eve-online-dscan-tool-for-wordpress')
			),
			'public' => true,
			'show_ui' => true,
//			'show_in_menu' => true,
			'supports' => array(
				'title',
				'editor',
//				'author',
//				'thumbnail',
//				'excerpt',
//				'revisions',
//				'trackbacks',
//				'comments'
			),
			'rewrite' => array(
				'slug' => $var_sSlug,
				'with_front' => true
			)
		));
	} // END public function customPostType()

	/**
	 * Getting the slug for the custom post type
	 *
	 * If the pages for looping the custom post types have not the same name
	 * as the custom post type, we need to find its slug to get it working.
	 *
	 * @since Talos 1.0
	 * @author ppfeufer
	 *
	 * @param string $var_sPosttype
	 */
	private function _getPosttypeSlug($var_sPosttype) {
		global $wpdb;

		$var_qry = '
			SELECT
				' . $wpdb->posts . '.post_name as post_name
			FROM
				' . $wpdb->posts . ',
				' . $wpdb->postmeta . '
			WHERE
				' . $wpdb->postmeta . '.meta_key = "_wp_page_template"
				AND ' . $wpdb->postmeta . '.meta_value = "page-' . $var_sPosttype . '.php"
				AND ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id;';

		$var_sSlugData = $wpdb->get_var($var_qry);

		/**
		 * Returning the slug or, if not found the name of custom post type
		 */
		if(!empty($var_sSlugData)) {
			return $var_sSlugData;
		} else {
			return $var_sPosttype;
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
	function templateLoader($template) {
		$templateFile = null;

		if(\is_singular('dscan')) {
			$templateFile = 'single-dscan.php';
		} elseif(\is_archive('fitting')) {
			$templateFile = 'archive-dscan.php';
		} // END if(\is_singular('fitting'))

		if($templateFile !== null) {
			if(\file_exists(EveOnlineDscanTool\Helper\TemplateHelper::locateTemplate($templateFile))) {
				$template = EveOnlineDscanTool\Helper\TemplateHelper::locateTemplate($templateFile);
			} // END if(\file_exists(EveOnlineDscanTool\Helper\TemplateHelper::locateTemplate($file)))
		} // END if($templateFile !== null)

		return $template;
	} // END function templateLoader($template)
} // END class PostType
