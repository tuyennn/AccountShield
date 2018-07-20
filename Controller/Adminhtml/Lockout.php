<?php
namespace GhoSter\AccountShield\Controller\Adminhtml;

abstract class Lockout extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'GhoSter_AccountShield::top_level';
    protected $_coreRegistry;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }


    /**
     * Init page
     *
     * @param @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return mixed
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('GhoSter'), __('GhoSter'))
            ->addBreadcrumb(__('Lockout'), __('Lockout'));
        return $resultPage;
    }
}