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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\ResourceLoader;

use WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\PluginHelper;
use WordPress\Plugins\EveOnlineIntelTool\Libs\Interfaces\AssetsInterface;
use WordPress\Plugins\EveOnlineIntelTool\Libs\PostType;

/**
 * JavaScript Loader
 */
class JavascriptLoader implements AssetsInterface {
    /**
     * Plugin Helper
     *
     * @var PluginHelper
     */
    private PluginHelper $pluginHelper;

    /**
     * Constructor
     */
    public function __construct() {
        $this->pluginHelper = PluginHelper::getInstance();
    }

    /**
     * Initialize the loader
     */
    public function init(): void {
        add_action(hook_name: 'wp_enqueue_scripts', callback: [$this, 'enqueue'], priority: 99);
    }

    /**
     * Load the JavaScript
     */
    public function enqueue(): void {
        /**
         * Only in Frontend
         */
        if (!is_admin()) {
            if (PostType::getInstance()->isPostTypePage() === true) {
                wp_enqueue_script(handle: 'bootstrap-js', src: $this->pluginHelper->getPluginUri(file: 'bootstrap/js/bootstrap.min.js'), deps: ['jquery'], ver: '', args: true);
                wp_enqueue_script(handle: 'data-tables-js', src: $this->pluginHelper->getPluginUri(file: 'js/data-tables/jquery.dataTables.min.js'), deps: ['jquery'], ver: '', args: true);
                wp_enqueue_script(handle: 'data-tables-bootstrap-js', src: $this->pluginHelper->getPluginUri(file: 'js/data-tables/dataTables.bootstrap.min.js'), deps: ['jquery', 'data-tables-js'], ver: '', args: true);
            }

            wp_enqueue_script(handle: 'copy-to-clipboard-js', src: $this->pluginHelper->getPluginUri(file: 'js/copy-to-clipboard.min.js'), deps: ['jquery'], ver: '', args: true);
            wp_enqueue_script(handle: 'eve-online-intel-tool-js', src: $this->pluginHelper->getPluginUri(file: 'js/eve-online-intel-tool.min.js'), deps: ['jquery'], ver: '', args: true);
            wp_localize_script(handle: 'eve-online-intel-tool-js', object_name: 'eveIntelToolL10n', l10n: $this->getJavaScriptTranslations());
        }
    }

    /**
     * Getting the translation array to translate strings in JavaScript
     *
     * @return array
     */
    private function getJavaScriptTranslations(): array {
        return [
            'copyToClipboard' => [
                'permalink' => [
                    'text' => [
                        'success' => __('Permalink successfully copied', 'eve-online-intel-tool'),
                        'error' => __('Something went wrong. Nothing copied. Maybe your browser doesn\'t support this function.', 'eve-online-intel-tool')
                    ]
                ]
            ],
            'dataTables' => [
                'translation' => [
                    'decimal' => __(',', 'eve-online-intel-tool'),
                    'thousands' => __('.', 'eve-online-intel-tool'),
                    'emptyTable' => __('No data available in table', 'eve-online-intel-tool'),
                    'info' => __('Showing _END_ entries', 'eve-online-intel-tool'),
                    'infoEmpty' => __('No records available', 'eve-online-intel-tool'),
                    'infoFiltered' => __('(filtered from _MAX_ total entries)', 'eve-online-intel-tool'),
                    'infoPostFix' => __('', 'eve-online-intel-tool'),
                    'lengthMenu' => __('Show _MENU_', 'eve-online-intel-tool'),
                    'loadingRecords' => __('Loading...', 'eve-online-intel-tool'),
                    'processing' => __('Processing...', 'eve-online-intel-tool'),
                    'zeroRecords' => __('Nothing found - sorry', 'eve-online-intel-tool'),
                    'search' => __('_INPUT_', 'eve-online-intel-tool'),
                    'searchPlaceholder' => __('Search...', 'eve-online-intel-tool'),
                    'paginate' => [
                        'first' => __('First', 'eve-online-intel-tool'),
                        'last' => __('Last', 'eve-online-intel-tool'),
                        'next' => __('Next', 'eve-online-intel-tool'),
                        'previous' => __('Previous', 'eve-online-intel-tool'),
                    ],
                    'aria' => [
                        'sortAscending' => __(': activate to sort column ascending', 'eve-online-intel-tool'),
                        'sortDescending' => __(': activate to sort column descending', 'eve-online-intel-tool'),
                    ]
                ]
            ],
            'ajax' => [
                'url' => admin_url(path: 'admin-ajax.php'),
                'loaderImage' => $this->pluginHelper->getPluginUri(file: 'images/loader-sprite.gif')
            ]
        ];
    }
}
