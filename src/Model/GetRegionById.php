<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\GetRegionByIdInterface;
use Eriocnemis\Region\Api\ConvertRegionToDataInterface;
use Eriocnemis\Region\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Region\Model\RegionFactory;

/**
 * Get region by id
 *
 * @api
 */
class GetRegionById implements GetRegionByIdInterface
{
    /**
     * @var RegionResource
     */
    private $resource;

    /**
     * @var RegionFactory
     */
    private $factory;

    /**
     * @var ConvertRegionToDataInterface
     */
    private $convertRegionToData;

    /**
     * Initialize provider
     *
     * @param RegionResource $resource
     * @param ConvertRegionToDataInterface $convertRegionToData
     * @param RegionFactory $factory
     */
    public function __construct(
        RegionResource $resource,
        ConvertRegionToDataInterface $convertRegionToData,
        RegionFactory $factory
    ) {
        $this->resource = $resource;
        $this->convertRegionToData = $convertRegionToData;
        $this->factory = $factory;
    }

    /**
     * Retrieve region by id
     *
     * @param int $regionId
     * @return RegionInterface
     * @throws NoSuchEntityException
     */
    public function execute($regionId): RegionInterface
    {
        /** @var \Magento\Framework\Model\AbstractModel $region */
        $region = $this->factory->create();
        $this->resource->load($region, $regionId, RegionInterface::REGION_ID);

        if (!$region->getId()) {
            throw new NoSuchEntityException(
                __('Region with id "%1" does not exist.', $regionId)
            );
        }
        return $this->convertRegionToData->execute($region);
    }
}
