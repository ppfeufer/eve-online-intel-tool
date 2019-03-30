<?php

/**
 * Copyright (C) 2017 Rounon Dax
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace WordPress\Plugins\EveOnlineIntelTool\Libs;

use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\TemplateHelper;
use \WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

\defined('ABSPATH') or die();

/**
 * Managing the custom post type
 */
class PostType extends AbstractSingleton {
    /**
     * Registering the custom post type
     */
    public function registerCustomPostType() {
        $cptSlug = $this->getPosttypeSlug('intel');

        $argsTaxonomyCategory = [
            'label' => \__('Category', 'eve-online-intel-tool'),
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

        /**
         * Adding our default categories ...
         *
         * » D-Scan
         * » Fleet Composition
         * » Local/Chat Scan
         */
        \wp_insert_term('D-Scan', 'intel_category', [
            'slug' => 'dscan'
        ]);
        \wp_insert_term('Fleet Composition', 'intel_category', [
            'slug' => 'fleetcomposition'
        ]);
        \wp_insert_term('Local Scan', 'intel_category', [
            'slug' => 'local'
        ]);
    }

    /**
     * Fired on plugin deactivation
     */
    public function unregisterCustomPostType() {
        \unregister_post_type('intel');
    }

    public function createPermalinks($postLink, $post) {
        $returnValue = $postLink;

        if(\is_object($post) && $post->post_type === 'intel') {
            $terms = \wp_get_object_terms($post->ID, 'intel_category');

            if($terms) {
                $returnValue = \str_replace('%intel_category%', $terms[0]->slug, $postLink);
            }
        }

        return $returnValue;
    }

    /**
     * Getting the slug for the custom post type
     *
     * If the pages for looping the custom post types have not the same name
     * as the custom post type, we need to find its slug to get it working.
     *
     * @global \wpdb $wpdb
     * @param string $postType
     * @return string
     */
    public function getPosttypeSlug(string $postType) {
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
                AND ' . $wpdb->posts . '.post_type = "page"
                AND ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id;';

        $slugData = $wpdb->get_var($var_qry);

        /**
         * Returning the slug or, if not found the name of custom post type
         */
        if(!empty($slugData)) {
            return $slugData;
        } else {
            return $postType;
        }
    }

    /**
     * Template loader.
     *
     * The template loader will check if WP is loading a template
     * for a specific Post Type and will try to load the template
     * from out 'templates' directory.
     *
     * @since 1.0.0
     *
     * @param string $template Template file that is being loaded.
     * @return string Template file that should be loaded.
     *
     * @param string $template
     * @return type
     */
    public function templateLoader(string $template) {
        $templateFile = null;

        if(\is_singular('intel')) {
            $templateFile = 'single-intel.php';
        } elseif(\is_archive() && (\get_post_type() === 'intel' || \is_post_type_archive('intel') === true)) {
            $templateFile = 'page-intel.php';
        }

        if($templateFile !== null) {
            if(\file_exists(TemplateHelper::getInstance()->locateTemplate($templateFile))) {
                $template = TemplateHelper::getInstance()->locateTemplate($templateFile);
            }
        }

        return $template;
    }

    /**
     * Registering a page template
     *
     * @param string $pageTemplate
     * @return string
     */
    public function registerPageTemplate(string $pageTemplate) {
        if(\is_page($this->getPosttypeSlug('intel'))) {
            $pageTemplate = PluginHelper::getInstance()->getPluginPath('templates/page-intel.php');
        }

        return $pageTemplate;
    }

    public function isPostTypePage() {
        $returnValue = false;

        if(\is_page($this->getPosttypeSlug('intel')) || \get_post_type() === 'intel' || \is_post_type_archive('intel') === true) {
            $returnValue = true;
        }

        return $returnValue;
    }
}
