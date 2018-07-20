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

use Magento\Framework\Exception\CouldNotSaveException;
use GhoSter\AccountShield\Model\ResourceModel\Lockout as ResourceLockout;
use GhoSter\AccountShield\Api\LockoutRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use GhoSter\AccountShield\Api\Data\LockoutSearchResultsInterfaceFactory;
use GhoSter\AccountShield\Model\ResourceModel\Lockout\CollectionFactory as LockoutCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use GhoSter\AccountShield\Api\Data\LockoutInterfaceFactory;
use Magento\Framework\Api\SortOrder;

class LockoutRepository implements lockoutRepositoryInterface
{

    protected $dataLockoutFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    private $storeManager;

    protected $resource;

    protected $lockoutFactory;

    protected $lockoutCollectionFactory;

    protected $dataObjectProcessor;


    /**
     * @param ResourceLockout $resource
     * @param LockoutFactory $lockoutFactory
     * @param LockoutInterfaceFactory $dataLockoutFactory
     * @param LockoutCollectionFactory $lockoutCollectionFactory
     * @param LockoutSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceLockout $resource,
        LockoutFactory $lockoutFactory,
        LockoutInterfaceFactory $dataLockoutFactory,
        LockoutCollectionFactory $lockoutCollectionFactory,
        LockoutSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->lockoutFactory = $lockoutFactory;
        $this->lockoutCollectionFactory = $lockoutCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataLockoutFactory = $dataLockoutFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
    ) {
        /* if (empty($lockout->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $lockout->setStoreId($storeId);
        } */
        try {
            $lockout->getResource()->save($lockout);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the lockout: %1',
                $exception->getMessage()
            ));
        }
        return $lockout;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($lockoutId)
    {
        $lockout = $this->lockoutFactory->create();
        $lockout->getResource()->load($lockout, $lockoutId);
        if (!$lockout->getId()) {
            throw new NoSuchEntityException(__('Lockout with id "%1" does not exist.', $lockoutId));
        }
        return $lockout;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->lockoutCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \GhoSter\AccountShield\Api\Data\LockoutInterface $lockout
    ) {
        try {
            $lockout->getResource()->delete($lockout);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Lockout: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($lockoutId)
    {
        return $this->delete($this->getById($lockoutId));
    }
}
