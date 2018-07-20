<?php

namespace GhoSter\AccountShield\Controller\Adminhtml\Lockout;

class DeleteAll extends \GhoSter\AccountShield\Controller\Adminhtml\Lockout
{

    /**
     * @var \GhoSter\AccountShield\Model\LockoutFactory
     */
    protected $lockoutFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \GhoSter\AccountShield\Model\LockoutFactory $lockoutFactory
    )
    {
        $this->lockoutFactory = $lockoutFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try {

            $collection = $this->lockoutFactory->create()->getCollection();
            if (!$collection->getSize()) {
                $this->messageManager->addErrorMessage(__('There are no items to delete.'));
            }

            foreach ($collection as $lockout) {
                $lockout->delete();
            }

            $this->messageManager->addSuccessMessage(__('All lockouts have been deleted.'));

            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}