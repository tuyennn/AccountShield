<?php

namespace GhoSter\AccountShield\Observer;

class Release implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

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
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \GhoSter\AccountShield\Helper\Data $helper,
        \GhoSter\AccountShield\Model\LockoutFactory $lockoutFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    )
    {
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
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

        /** @var $customer \Magento\Customer\Model\Customer */
        $customer = $observer->getCustomer();


        if ($customer->getEmail()) {

            /** @var $lockoutModel \GhoSter\AccountShield\Model\Lockout */
            $lockoutModel = $this->lockoutFactory->create()->getCollection()
                ->addFieldToFilter('username', $customer->getEmail())
                ->addFieldToFilter('website_id', $websiteId)
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