<?php

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons;

\defined('ABSPATH') or die();

abstract class AbstractSingleton {
	protected function __construct() {
		;
	} // END protected function __construct()

	final public static function getInstance() {
		static $instances = [];

		$calledClass = \get_called_class();

		if(!isset($instances[$calledClass])) {
			$instances[$calledClass] = new $calledClass();
		} // END if(!isset($instances[$calledClass]))

		return $instances[$calledClass];
	} // END final public static function getInstance()

	final private function __clone() {
		;
	} // END final private function __clone()
} // END abstract class AbstractSingleton
