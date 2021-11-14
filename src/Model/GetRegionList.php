<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterfaceFactory;
use Eriocnemis\RegionApi\Api\GetRegionListInterface;
use Eriocnemis\Region\Api\ConvertRegionToDataInterface;
use Eriocnemis\Region\Model\ResourceModel\Region\CollectionFactory;

/**
 * Find regions by search criteria
 *
 * @api
 */
class GetRegionList implements GetRegionListInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var RegionSearchResultInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ConvertRegionToDataInterface
     */
    private $convertRegionToData;

    /**
     * Initialize provider
     *
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RegionSearchResultInterfaceFactory $searchResultsFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ConvertRegionToDataInterface $convertRegionToData
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RegionSearchResultInterfaceFactory $searchResultsFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ConvertRegionToDataInterface $convertRegionToData
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->convertRegionToData = $convertRegionToData;
    }

    /**
     * Retrieve list of regions
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return RegionSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): RegionSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        }
        $this->collectionProcessor->process($searchCriteria, $collection);

        $items = [];
        /** @var \Eriocnemis\Region\Model\Region $model */
        foreach ($collection->getItems() as $model) {
            $items[] = $this->convertRegionToData->execute($model);
        }

        /** @var RegionSearchResultInterface $searchResult */
        $searchResult = $this->searchResultsFactory->create();
        $searchResult->setItems($items);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
