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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Ajax;

use WordPress\Plugins\EveOnlineIntelTool\Libs\Interfaces\AjaxInterface;

class FormNonce implements AjaxInterface {
    /**
     * Constructor
     */
    public function __construct() {
        $this->initActions();
    }

    /**
     * Initialize WP Actions
     *
     * @return void
     */
    public function initActions(): void {
        add_action(
            hook_name: 'wp_ajax_nopriv_get-eve-intel-form-nonce',
            callback: [$this, 'ajaxAction']
        );
        add_action(
            hook_name: 'wp_ajax_get-eve-intel-form-nonce',
            callback: [$this, 'ajaxAction']
        );
    }

    /**
     * Ajax Action
     *
     * @return void
     */
    public function ajaxAction(): void {
        $nonce = wp_create_nonce(action: 'eve-online-intel-tool-new-intel-form');

        wp_send_json(response: $nonce);

        // always exit this API function
        exit;
    }
}
