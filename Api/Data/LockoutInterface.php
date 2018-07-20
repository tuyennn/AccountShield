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

interface LockoutInterface
{

    const USERNAME = 'username';
    const FAILURES_NUM = 'failures_num';
    const WEBSITE_ID = 'website_id';
    const LAST_FAILURE_AT = 'last_failure_at';
    const UPDATED_AT = 'updated_at';
    const CUR_FAILURE_NUM = 'cur_failure_num';
    const TYPE = 'type';
    const ID = 'id';
    const CREATED_AT = 'created_at';
    const LOGNUM = 'lognum';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setId($id);

    /**
     * Get username
     * @return string|null
     */
    public function getUsername();

    /**
     * Set username
     * @param string $username
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setUsername($username);

    /**
     * Get lognum
     * @return string|null
     */
    public function getLognum();

    /**
     * Set lognum
     * @param string $lognum
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setLognum($lognum);

    /**
     * Get failures_num
     * @return string|null
     */
    public function getFailuresNum();

    /**
     * Set failures_num
     * @param string $failures_num
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setFailuresNum($failures_num);

    /**
     * Get cur_failure_num
     * @return string|null
     */
    public function getCurFailureNum();

    /**
     * Set cur_failure_num
     * @param string $cur_failure_num
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setCurFailureNum($cur_failure_num);

    /**
     * Get last_failure_at
     * @return string|null
     */
    public function getLastFailureAt();

    /**
     * Set last_failure_at
     * @param string $last_failure_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setLastFailureAt($last_failure_at);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setType($type);

    /**
     * Get website_id
     * @return string|null
     */
    public function getWebsiteId();

    /**
     * Set website_id
     * @param string $website_id
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setWebsiteId($website_id);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setCreatedAt($created_at);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updated_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setUpdatedAt($updated_at);
}
