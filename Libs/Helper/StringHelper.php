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

namespace WordPress\Plugins\EveOnlineIntelTool\Libs\Helper;

use WordPress\Plugins\EveOnlineIntelTool\Libs\Singletons\AbstractSingleton;

/**
 * Helper Class for manipulating and/or checking strings
 */
class StringHelper extends AbstractSingleton {
    /**
     * Make a string camelCase
     *
     * @param string $string
     * @param bool $ucFirst
     * @param array $noStrip
     * @return string
     */
    public function camelCase(string $string, bool $ucFirst = false, array $noStrip = []): string {
        // First we make sure all is lower case
        $string = strtolower(string: $string);

        // non-alpha and non-numeric characters become spaces
        $string = preg_replace(pattern: '/[^a-z0-9' . implode('', $noStrip) . ']+/i', replacement: ' ', subject: $string);
        $string = trim(string: $string);

        // uppercase the first character of each word
        $string = ucwords(string: $string);
        $string = str_replace(search: ' ', replace: '', subject: $string);

        if ($ucFirst === false) {
            $string = lcfirst(string: $string);
        }

        return $string;
    }

    /**
     * Correcting line breaks
     *
     * mac -> linux
     * windows -> linux
     *
     * @param string $scanData
     * @return string
     */
    public function fixLineBreaks(string $scanData): string {
        return str_replace(["\r\n", "\r"], "\n", $scanData);
    }
}
