<?php

namespace GhoSter\AccountShield\Controller\Adminhtml\Lockout;

class Delete extends \GhoSter\AccountShield\Controller\Adminhtml\Lockout
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

        $id = $this->getRequest()->getParam('lockout_id');
        if ($id) {
            try {

                $model = $this->lockoutFactory->create();
                $model->load($id);
                $model->delete();

                $this->messageManager->addSuccessMessage(__('A lockout item has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['lockout_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('Unable to find a lockout item.'));
        return $resultRedirect->setPath('*/*/');
    }
}