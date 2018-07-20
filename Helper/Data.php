<?php

namespace GhoSter\AccountShield\Helper;

use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Check lockout enabled or not - System Configuration
     *
     * @var boolean
     */
    const XML_PATH_ENABLED = 'accountshield/account/enable';

    /**
     * Maximum allowed login attempts - System Configuration
     *
     * @var integer
     */
    const XML_PATH_MAX_LIMIT = 'accountshield/account/max_limit';

    /**
     * Account lock duration in seconds - System Configuration
     *
     * @var integer
     */
    const XML_PATH_INTERVAL = 'accountshield/account/interval';


    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateFormat;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_date;


    public function __construct(
        Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime $dateFormat,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    )
    {
        $this->logger = $logger;
        $this->dateFormat = $dateFormat;
        $this->dateTime = $dateTime;
        $this->_date = $date;
        parent::__construct($context);
    }


    /**
     * Check lockout enabled or not - System Configuration
     *
     * @param $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Maximum allowed login attempts - System Configuration
     * @param $store
     * @return integer
     */
    public function getMaxLimit($store = null)
    {
        return is_numeric($this->scopeConfig->getValue(
            self::XML_PATH_MAX_LIMIT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        )) ? $this->scopeConfig->getValue(
            self::XML_PATH_MAX_LIMIT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        ) : 3;
    }

    /**
     * Account lock duration in seconds - System Configuration
     * @param $store
     * @return integer
     */
    public function getInterval($store = null)
    {
        return is_numeric($this->scopeConfig->getValue(
            self::XML_PATH_INTERVAL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        )) ? $this->scopeConfig->getValue(
            self::XML_PATH_INTERVAL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        ) : 900;
    }

    /**
     * Check whether a lockout time has been expired.
     *
     * @param  $time string
     * @return boolean
     */
    public function isIntervalExceeds($time)
    {
        $isAllow = false;

        if ($time) {
            $timestamp = $this->dateTime->timestamp($time);
            $now = $this->dateTime->timestamp($this->_date->date());

            $isAllow = (($this->remTime($time) / 60) == 0);
        }

        exit('int: ' . ($this->remTime($time) / 60));

        return $isAllow;
    }

    /**
     * Check whether a lockout has remaining time to expire.
     *
     * @param $time string
     * @return timestamp
     */
    public function remTime($time)
    {
        $rem = 0;

        if ($time) {
            $timestamp = $this->dateTime->timestamp($time);
            $endTime = $timestamp + $this->getInterval();
            $now = $this->dateTime->timestamp($this->_date->date());

            $rem = intval($endTime - $now);
            $rem = ($rem < 0) ? 0 : $rem;
        }

        return $rem;
    }

}