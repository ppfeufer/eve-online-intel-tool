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

namespace WordPress\EsiClient;

\defined('ABSPATH') or die();

if(!\class_exists('\WordPress\EsiClient\Swagger')) {
    class Swagger {
        /**
         * ESI URL
         *
         * @var string
         */
        private $esiUrl = 'https://esi.evetech.net/';

        /**
         * ESI Version
         *
         * @var string
         */
        protected $esiVersion = 'latest/';

        /**
         * ESI method
         *
         * @var string
         */
        protected $esiMethod = 'get';

        /**
         * ESI route
         *
         * @var string
         */
        protected $esiRoute = null;

        /**
         * ESI route parameter
         *
         * @var array
         */
        protected $esiRouteParameter = [];

        /**
         * ESI POST parameter
         *
         * @var array
         */
        protected $esiPostParameter = [];

        /**
         * Remote Helper
         *
         * @var \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper
         */
        protected $remoteHelper = null;

        /**
         * Constructor
         */
        public function __construct() {
            $this->remoteHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper::getInstance();
        }

        /**
         * Call ESI
         *
         * @return stdClass Object
         */
        public function callEsi() {
            $returnValue = null;

            if(!\is_a($this->remoteHelper, '\WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper')) {
                $this->remoteHelper = \WordPress\Plugins\EveOnlineIntelTool\Libs\Helper\RemoteHelper::getInstance();
            }

            $esiUrl = \trailingslashit($this->getEsiUrl() . $this->getEsiVersion());
            $esiRoute = $this->getEsiRoute();

            if(\count($this->getEsiRouteParameter()) > 0) {
                $esiRoute = \preg_replace(\array_keys($this->getEsiRouteParameter()), \array_values($this->getEsiRouteParameter()), $this->getEsiRoute());
            }

            $callUrl = $esiUrl . $esiRoute;

            switch($this->getEsiMethod()) {
                case 'get':
                    $returnValue = $this->remoteHelper->getRemoteData($callUrl);
                    break;

                case 'post':
                    $returnValue = $this->remoteHelper->getRemoteData($callUrl, $this->getEsiMethod(), $this->getEsiPostParameter());
                    break;
            }

            $this->resetFieldsToDefaults();

            return $returnValue;
        }

        /**
         * Resetting field values to defaults
         */
        private function resetFieldsToDefaults() {
            foreach(\get_class_vars(\get_class($this)) as $field => $defaultValue) {
                $this->$field = $defaultValue;
            }
        }

        /**
         * getEsiMethod
         *
         * @return string
         */
        public function getEsiMethod() {
            return $this->esiMethod;
        }

        /**
         * setEsiMethod
         *
         * @param string $esiMethod
         */
        public function setEsiMethod($esiMethod) {
            $this->esiMethod = $esiMethod;
        }

        /**
         * getEsiPostParameter
         *
         * @return array
         */
        public function getEsiPostParameter() {
            return $this->esiPostParameter;
        }

        /**
         * setEsiPostParameter
         *
         * @param array $esiPostParameter
         */
        public function setEsiPostParameter(array $esiPostParameter) {
            $this->esiPostParameter = $esiPostParameter;
        }

        /**
         * getEsiRoute
         *
         * @return string
         */
        public function getEsiRoute() {
            return $this->esiRoute;
        }

        /**
         * setEsiRoute
         *
         * @param string $esiRoute
         */
        public function setEsiRoute($esiRoute) {
            $this->esiRoute = $esiRoute;
        }

        /**
         * getEsiRouteParameter
         *
         * @return array
         */
        public function getEsiRouteParameter() {
            return $this->esiRouteParameter;
        }

        /**
         * setEsiRouteParameter
         *
         * @param array $esiRouteParameter
         */
        public function setEsiRouteParameter(array $esiRouteParameter) {
            $this->esiRouteParameter = $esiRouteParameter;
        }

        /**
         * getEsiUrl
         *
         * @return string
         */
        public function getEsiUrl() {
            return $this->esiUrl;
        }

        /**
         * getEsiVersion
         *
         * @return string
         */
        public function getEsiVersion() {
            return $this->esiVersion;
        }

        /**
         * setEsiVersion
         *
         * @param string $esiVersion
         */
        public function setEsiVersion($esiVersion) {
            $this->esiVersion = $esiVersion;
        }

        /**
         *
         * @param string $jSon
         * @param object $object
         * @return object
         */
        public function map($jSon, $object) {
            $returnValue = null;

            if(!\is_null($jSon)) {
                $jsonMapper = new \WordPress\EsiClient\Mapper\JsonMapper;
                $returnValue = $jsonMapper->map(\json_decode($jSon), $object);
            }

            return $returnValue;
        }

        public function mapArray($jSon, $class) {
            $returnValue = null;

            if(!\is_null($jSon)) {
                $jsonMapper = new \WordPress\EsiClient\Mapper\JsonMapper;
                $returnValue = $jsonMapper->mapArray(\json_decode($jSon), [], $class);
            }

            return $returnValue;
        }
    }
}
