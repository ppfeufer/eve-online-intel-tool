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

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Helper;

\defined('ABSPATH') or die();

/**
 * Helper Class for manipulating and/or checking strings
 */
class StringHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton {
	/**
	 * Make a string camelCase
	 *
	 * @param string $string
	 * @param boolean $ucFirst
	 * @param array $noStrip
	 * @return string
	 */
	public function camelCase($string, $ucFirst = false, $noStrip = []) {
		// First we make sure all is lower case
		$string = \strtolower($string);

		// non-alpha and non-numeric characters become spaces
		$string = \preg_replace('/[^a-z0-9' . \implode('', $noStrip) . ']+/i', ' ', $string);
		$string = \trim($string);

		// uppercase the first character of each word
		$string = \ucwords($string);
		$string = \str_replace(' ', '', $string);

		if($ucFirst === false) {
			$string = \lcfirst($string);
		} // if($ucFirst === false)

		return $string;
	} // public static function camelCase($string, $ucFirst = false, $noStrip = [])
} // class StringHelper extends \WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton
