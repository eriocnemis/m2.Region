<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\DeleteRegionByIdInterface;
use Eriocnemis\Region\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Region\Model\RegionFactory;

/**
 * Delete region by id
 *
 * @api
 */
class DeleteRegionById implements DeleteRegionByIdInterface
{
    /**
     * @var RegionFactory
     */
    private $factory;

    /**
     * @var RegionResource
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize provider
     *
     * @param RegionResource $resource
     * @param RegionFactory $factory
     * @param LoggerInterface $logger
     */
    public function __construct(
        RegionResource $resource,
        RegionFactory $factory,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
        $this->logger = $logger;
    }

    /**
     * Delete region by id
     *
     * @param int $regionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function execute($regionId): bool
    {
        /** @var \Magento\Framework\Model\AbstractModel $region */
        $region = $this->factory->create();
        $this->resource->load($region, $regionId, RegionInterface::REGION_ID);

        if (!$region->getId()) {
            throw new NoSuchEntityException(
                __('Region with id "%1" does not exist.', $regionId)
            );
        }

        try {
            $this->resource->delete($region);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotDeleteException(
                __('Could not delete the region with id: %1', $regionId)
            );
        }
        return true;
    }
}
