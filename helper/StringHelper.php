<?php
namespace WordPress\Plugin\EveOnlineDscanTool\Helper;

/**
 * Helper Class for manipulating and/or checking strings
 */
class StringHelper {
	/**
	 * Make a string camelCase
	 *
	 * @param string $string
	 * @param boolean $ucFirst
	 * @param array $noStrip
	 * @return string
	 */
	public static function camelCase($string, $ucFirst = false, $noStrip = array()) {
		// First we make sure all is lower case
		$string = strtolower($string);

		// non-alpha and non-numeric characters become spaces
		$string = preg_replace('/[^a-z0-9' . implode('', $noStrip) . ']+/i', ' ', $string);
		$string = trim($string);

		// uppercase the first character of each word
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);

		if($ucFirst === false) {
			$string = lcfirst($string);
		} // END if($ucFirst === false)

		return $string;
	} // END public static function camelCase($string, $ucFirst = false, $noStrip = array())
} // END class StringHelper
