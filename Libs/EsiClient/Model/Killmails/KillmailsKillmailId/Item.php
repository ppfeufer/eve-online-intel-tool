<?php

/*
 * Copyright (C) 2018 ppfeufer
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

namespace WordPress\EsiClient\Model\Killmails\KillmailsKillmailId;

class Item {
    /**
     * flag
     *
     * Flag for the location of the item
     *
     * @var int
     */
    protected $flag = null;

    /**
     * itemTypeId
     *
     * @var int
     */
    protected $itemTypeId = null;

    /**
     * items
     *
     * @var array
     */
    protected $items = null;

    /**
     * quantityDestroyed
     *
     * @var int
     */
    protected $quantityDestroyed = null;

    /**
     * quantityDropped
     *
     * @var int
     */
    protected $quantityDropped = null;

    /**
     * singleton
     * @var int
     */
    protected $singleton = null;

    /**
     * getFlag
     *
     * @return int
     */
    public function getFlag() {
        return $this->flag;
    }

    /**
     * setFlag
     *
     * @param int $flag
     */
    public function setFlag($flag) {
        $this->flag = $flag;
    }

    /**
     * getItemTypeId
     *
     * @return int
     */
    public function getItemTypeId() {
        return $this->itemTypeId;
    }

    /**
     * setItemTypeId
     *
     * @param int $itemTypeId
     */
    public function setItemTypeId($itemTypeId) {
        $this->itemTypeId = $itemTypeId;
    }

    /**
     * getItems
     *
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * setItems
     *
     * @param array $items
     */
    public function setItems(array $items) {
        $mapper = new \WordPress\EsiClient\Mapper\JsonMapper;

        $this->items = $mapper->mapArray($items, [], '\\WordPress\EsiClient\Model\Killmails\KillmailsKillmailId\ItemItems');
    }

    /**
     * getQuantityDestroyed
     *
     * @return int
     */
    public function getQuantityDestroyed() {
        return $this->quantityDestroyed;
    }

    /**
     * setQuantityDestroyed
     *
     * @param int $quantityDestroyed
     */
    public function setQuantityDestroyed($quantityDestroyed = null) {
        $this->quantityDestroyed = $quantityDestroyed;
    }

    /**
     * getQuantityDropped
     *
     * @return int
     */
    public function getQuantityDropped() {
        return $this->quantityDropped;
    }

    /**
     * setQuantityDropped
     *
     * @param int $quantityDropped
     */
    public function setQuantityDropped($quantityDropped = null) {
        $this->quantityDropped = $quantityDropped;
    }

    /**
     * getSingleton
     *
     * @return int
     */
    public function getSingleton() {
        return $this->singleton;
    }

    /**
     * setSingletion
     *
     * @param int $singleton
     */
    public function setSingleton($singleton) {
        $this->singleton = $singleton;
    }
}
