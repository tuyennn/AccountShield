<?php

namespace GhoSter\AccountShield\Ui\Component\Listing\Column;

class LockoutActions extends \Magento\Ui\Component\Listing\Columns\Column
{

    const URL_PATH_DELETE = 'ghoster_accountshield/lockout/delete';
    const URL_PATH_DELETE_ALL = 'ghoster_accountshield/lockout/deleteAll';
    const URL_PATH_UNLOCK = 'ghoster_accountshield/lockout/unlock';
    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'unlock' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_UNLOCK,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Unlock'),
                            'confirm' => [
                                'title' => __('Unlock "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to unlock a "${ $.$data.title }" record?')
                            ]
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}