<?php
/**
 * A Magento 2 module named GhoSter/AccountShield
 * Copyright (C) 2017 Tuyen Nguyen
 * 
 * This file is part of GhoSter/AccountShield.
 * 
 * GhoSter/AccountShield is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace GhoSter\AccountShield\Api\Data;

interface LockoutSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Lockout list.
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \GhoSter\AccountShield\Api\Data\LockoutInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
