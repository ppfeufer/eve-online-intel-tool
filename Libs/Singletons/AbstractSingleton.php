<?php

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons;

\defined('ABSPATH') or die();

abstract class AbstractSingleton {
    protected function __construct() {
        ;
    }

    final public static function getInstance() {
        static $instances = [];

        $calledClass = \get_called_class();

        if(!isset($instances[$calledClass])) {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }

    final private function __clone() {
        ;
    }
}
