<?php

/*
 * Copyright (C) 2018 p.pfeufer
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

namespace WordPress\EsiClient\Repository;

\defined('ABSPATH') or die();

class DogmaRepository extends \WordPress\EsiClient\Swagger {
    /**
     * Used ESI enpoints in this class
     *
     * @var array ESI enpoints
     */
    protected $esiEndpoints = [
        'dogma_attributes' => 'dogma/attributes/?datasource=tranquility',
        'dogma_attributes_attributeId' => 'dogma/attributes/{attribute_id}/?datasource=tranquility',
        'dogma_dynamic_items_typeId_itemId' => 'dogma/dynamic/items/{type_id}/{item_id}/?datasource=tranquility',
        'dogma_effects' => 'dogma/effects/?datasource=tranquility',
        'dogma_effects_effectId' => 'dogma/effects/{effect_id}/?datasource=tranquility'
    ];

    /**
     * Get a list of dogma attribute ids
     *
     * @return object
     */
    public function dogmaAttributes() {
        $this->setEsiRoute($this->esiEndpoints['dogma_attributes']);
        $this->setEsiVersion('v1');

        $typeData = $this->callEsi();

        return $typeData;
    }

    /**
     * Get information on a dogma attribute
     *
     * @param int $attributeId A dogma attribute ID
     * @return \WordPress\EsiClient\Model\Dogma\DogmaAttributesAttributeId
     */
    public function dogmaAttributesAttributeId($attributeId) {
        $this->setEsiMethod('get');
        $this->setEsiRoute($this->esiEndpoints['dogma_attributes_attributeId']);
        $this->setEsiRouteParameter([
            '/{attribute_id}/' => $attributeId
        ]);
        $this->setEsiVersion('v1');

        return $this->map($this->callEsi(), new \WordPress\EsiClient\Model\Dogma\DogmaAttributesAttributeId);
    }
}
