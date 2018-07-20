<?php

namespace GhoSter\AccountShield\Observer;


class AdminLock implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var \Magento\User\Model\User
     */
    protected $adminUser;

    /**
     * @var \GhoSter\AccountShield\Helper\Data
     */
    protected $helper;

    /**
     * @var \GhoSter\AccountShield\Model\LockoutFactory
     */
    protected $lockoutFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @var \Magento\Framework\App\ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_date;

    public function __construct(
        \Magento\User\Model\User $adminUser,
        \GhoSter\AccountShield\Helper\Data $helper,
        \GhoSter\AccountShield\Model\LockoutFactory $lockoutFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    )
    {
        $this->adminUser = $adminUser;
        $this->helper = $helper;
        $this->lockoutFactory = $lockoutFactory;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->responseFactory = $responseFactory;
        $this->messageManager = $messageManager;
        $this->_date = $date;

    }


    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $websiteId = $this->storeManager->getStore()->getWebsiteId();

        if (!$this->helper->isEnabled()) {
            return $this;
        }

        $username = $observer->getUsername();
        $result = $observer->getResult();

        // Check admin user exists
        /** @var $adminUser \Magento\User\Model\User */
        $adminUser = $this->adminUser->loadByUsername($username);
        if (!$adminUser->getId())
            return $this;


        /** @var $lockoutModel \GhoSter\AccountShield\Model\Lockout */
        $lockoutModel = $this->lockoutFactory->create()->getCollection()
            ->addFieldToFilter('username', $username)
            ->addFieldToFilter('type', 2)
            ->getFirstItem();


        $lastFailureAt = $lockoutModel->getLastFailureAt();

        if (($lockoutModel->getCurFailureNum() >= $this->helper->getMaxLimit()) && $this->helper->remTime($lastFailureAt)) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Your account has been locked!. Please try again after %1 Mins', ceil($this->helper->remTime($lastFailureAt) / 60)));
        }


        if (!$result) {
            $failureNum = intval($lockoutModel->getFailuresNum()) + 1;
            $curFailureNum = intval($lockoutModel->getCurFailureNum()) + 1;

            // Reset again
            if (($lockoutModel->getCurFailureNum() >= $lockoutModel->getMaxLimit()) && !$lockoutModel->remTime($lastFailureAt))
                $curFailureNum = 1;

            $lockoutModel->setUsername($username);
            $lockoutModel->setFailuresNum($failureNum);
            $lockoutModel->setCurFailureNum($curFailureNum);
            $lockoutModel->setLastFailureAt($this->_date->date()->format('Y-m-d H:i:s'));
            $lockoutModel->setType($lockoutModel->getAdminhtmlLoginId());
            $lockoutModel->setWebsiteId($websiteId);
            $lockoutModel->save();
        }

        return $this;
    }

}