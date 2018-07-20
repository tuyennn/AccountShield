<?php

namespace GhoSter\AccountShield\Observer;


class AdminRelease implements \Magento\Framework\Event\ObserverInterface
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
        if (!$this->helper->isEnabled()) {
            return $this;
        }

        /** @var $adminUser \Magento\User\Model\User */
        $adminUser = $observer->getUser();

        if ($adminUser->getUsername()) {
            /** @var $lockoutModel \GhoSter\AccountShield\Model\Lockout */
            $lockoutModel = $this->lockoutFactory->create()->getCollection()
                ->addFieldToFilter('username', $adminUser->getUsername())
                ->addFieldToFilter('type', 2)
                ->getFirstItem();

            if ($lockoutModel->getId()) {
                $lognum = intval($lockoutModel->getLognum()) + 1;

                $lockoutModel->setLognum($lognum);
                $lockoutModel->setCurFailureNum(0);
                $lockoutModel->save();
            }
        }

        return $this;
    }

}