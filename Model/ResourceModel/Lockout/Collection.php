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

namespace GhoSter\AccountShield\Model\ResourceModel\Lockout;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'GhoSter\AccountShield\Model\Lockout',
            'GhoSter\AccountShield\Model\ResourceModel\Lockout'
        );
    }
}
