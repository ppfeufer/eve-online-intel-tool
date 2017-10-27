<?php

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Singletons;

\defined('ABSPATH') or die();

abstract class AbstractSingleton {
	protected function __construct() {
		;
	} // protected function __construct()

	final public static function getInstance() {
		static $instances = [];

		$calledClass = \get_called_class();

		if(!isset($instances[$calledClass])) {
			$instances[$calledClass] = new $calledClass();
		} // if(!isset($instances[$calledClass]))

		return $instances[$calledClass];
	} // final public static function getInstance()

	final private function __clone() {
		;
	} // final private function __clone()
} // abstract class AbstractSingleton
