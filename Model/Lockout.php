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

namespace GhoSter\AccountShield\Model;

use GhoSter\AccountShield\Api\Data\LockoutInterface;

class Lockout extends \Magento\Framework\Model\AbstractModel implements LockoutInterface
{

    /**
     * Frontend lockout flag
     *
     * @var integer
     */
    const FRONTEND_LOGIN = 1;

    /**
     * Adminhtml lockout flag
     *
     * @var integer
     */
    const ADMINHTML_LOGIN = 2;


    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('GhoSter\AccountShield\Model\ResourceModel\Lockout');
    }

    /**
     * Get id
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     * @param string $id
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get username
     * @return string
     */
    public function getUsername()
    {
        return $this->getData(self::USERNAME);
    }

    /**
     * Set username
     * @param string $username
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setUsername($username)
    {
        return $this->setData(self::USERNAME, $username);
    }

    /**
     * Get lognum
     * @return string
     */
    public function getLognum()
    {
        return $this->getData(self::LOGNUM);
    }

    /**
     * Set lognum
     * @param string $lognum
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setLognum($lognum)
    {
        return $this->setData(self::LOGNUM, $lognum);
    }

    /**
     * Get failures_num
     * @return string
     */
    public function getFailuresNum()
    {
        return $this->getData(self::FAILURES_NUM);
    }

    /**
     * Set failures_num
     * @param string $failures_num
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setFailuresNum($failures_num)
    {
        return $this->setData(self::FAILURES_NUM, $failures_num);
    }

    /**
     * Get cur_failure_num
     * @return string
     */
    public function getCurFailureNum()
    {
        return $this->getData(self::CUR_FAILURE_NUM);
    }

    /**
     * Set cur_failure_num
     * @param string $cur_failure_num
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setCurFailureNum($cur_failure_num)
    {
        return $this->setData(self::CUR_FAILURE_NUM, $cur_failure_num);
    }

    /**
     * Get last_failure_at
     * @return string
     */
    public function getLastFailureAt()
    {
        return $this->getData(self::LAST_FAILURE_AT);
    }

    /**
     * Set last_failure_at
     * @param string $last_failure_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setLastFailureAt($last_failure_at)
    {
        return $this->setData(self::LAST_FAILURE_AT, $last_failure_at);
    }

    /**
     * Get type
     * @return string
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * Set type
     * @param string $type
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get website_id
     * @return string
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * Set website_id
     * @param string $website_id
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setWebsiteId($website_id)
    {
        return $this->setData(self::WEBSITE_ID, $website_id);
    }

    /**
     * Get created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $created_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * Get updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updated_at
     * @return \GhoSter\AccountShield\Api\Data\LockoutInterface
     */
    public function setUpdatedAt($updated_at)
    {
        return $this->setData(self::UPDATED_AT, $updated_at);
    }


    /**
     * Get a frontend lockout flag
     *
     * @return integer
     */
    public function getFrontendLoginId() {
        return self::FRONTEND_LOGIN;
    }

    /**
     * Get a Adminhtml lockout flag
     *
     * @return integer
     */
    public function getAdminhtmlLoginId() {
        return self::ADMINHTML_LOGIN;
    }
}
