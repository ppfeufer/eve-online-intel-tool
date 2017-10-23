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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Ajax;

\defined('ABSPATH') or die();

class FormNonce implements \WordPress\Plugin\EveOnlineIntelTool\Libs\Interfaces\AjaxInterface {
	public function __construct() {
		$this->initActions();
	} // END public function __construct()

	public function ajaxAction() {
		$nonce = \wp_create_nonce('eve-online-intel-tool-new-intel-form');

		\wp_send_json($nonce);

		// always exit this API function
		exit;
	} // END public function ajaxAction()

	public function initActions() {
		\add_action('wp_ajax_nopriv_get-eve-intel-form-nonce', [$this, 'ajaxAction']);
		\add_action('wp_ajax_get-eve-intel-form-nonce', [$this, 'ajaxAction']);
	} // END public function initActions()
} // END class FormNonce
