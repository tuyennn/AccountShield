<?php

namespace GhoSter\AccountShield\Observer;

class Lock implements \Magento\Framework\Event\ObserverInterface
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
        /** @var $controller \Magento\Customer\Controller\Account\LoginPost */
        $controller = $observer->getControllerAction();

        $websiteId = $this->storeManager->getStore()->getWebsiteId();

        if (!$this->helper->isEnabled()) {
            return $this;
        }

        if ($controller->getActionFlag()->get('', \Magento\Framework\App\ActionInterface::FLAG_NO_DISPATCH))
            return $this;

        /** @var $customer \Magento\Customer\Model\Customer */
        $customer = $this->customerFactory->create();

        if (isset($websiteId)) {
            $customer->setWebsiteId($websiteId);
        }

        if ($observer->getRequest()->isPost()) {
            $login = $observer->getRequest()->getPost('login');

            if (!empty($login['username']) && !empty($login['password'])) {

                // Customer exists check
                $checkCustomer = $customer->loadByEmail($login['username']);
                if (!$checkCustomer->getId())
                    return $this;

                /** @var $lockoutModel \GhoSter\AccountShield\Model\Lockout */
                $lockoutModel = $this->lockoutFactory->create()->getCollection()
                    ->addFieldToFilter('username', $login['username'])
                    ->addFieldToFilter('website_id', $websiteId)
                    ->getFirstItem();

                $lastFailureAt = $lockoutModel->getLastFailureAt();

                if (($lockoutModel->getCurFailureNum() >= $this->helper->getMaxLimit()) && $this->helper->remTime($lastFailureAt)) {
                    $this->messageManager->addErrorMessage(__('Your account has been locked!. Please try again after %1 Mins', ceil($this->helper->remTime($lastFailureAt) / 60)));
                    $this->responseFactory->create()->setRedirect($this->url->getUrl('*/*'))->sendResponse();
                    return $this;
                }

                try {

                    $customer->authenticate($login['username'], $login['password']);

                } catch (\Exception $e) {

                    $failureNum = intval($lockoutModel->getFailuresNum()) + 1;
                    $curFailureNum = intval($lockoutModel->getCurFailureNum()) + 1;

                    // Reset again
                    if (($lockoutModel->getCurFailureNum() >= $this->helper->getMaxLimit()) && !$this->helper->remTime($lastFailureAt))
                        $curFailureNum = 1;

                    $lockoutModel->setUsername($login['username']);
                    $lockoutModel->setFailuresNum($failureNum);
                    $lockoutModel->setCurFailureNum($curFailureNum);
                    $lockoutModel->setLastFailureAt($this->_date->date()->format('Y-m-d H:i:s'));
                    $lockoutModel->setType($lockoutModel->getFrontendLoginId());
                    $lockoutModel->setWebsiteId($websiteId);
                    $lockoutModel->save();
                }
            }
        }

        return $this;
    }

}