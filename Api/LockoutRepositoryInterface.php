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

namespace GhoSter\AccountShield\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LockoutRepositoryInterface
{


    /**
     * Save Lockout
     * @param \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
    );

    /**
     * Retrieve Lockout
     * @param string $lockoutId
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($lockoutId);

    /**
     * Retrieve Lockout matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \GhoSter\AccountShield\Api\Data\LockoutSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Lockout
     * @param \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
    );

    /**
     * Delete Lockout by ID
     * @param string $lockoutId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($lockoutId);
}
