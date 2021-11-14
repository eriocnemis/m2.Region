<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Validation\ValidationException;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\SaveRegionInterface;
use Eriocnemis\RegionApi\Api\ValidateRegionInterface;
use Eriocnemis\Region\Api\ConvertRegionToDataInterface;
use Eriocnemis\Region\Api\ConvertDataToRegionInterface;
use Eriocnemis\Region\Model\ResourceModel\Region as RegionResource;

/**
 * Save region data
 *
 * @api
 */
class SaveRegion implements SaveRegionInterface
{
    /**
     * @var RegionResource
     */
    private $resource;

    /**
     * @var ValidateRegionInterface
     */
    private $validateRegion;

    /**
     * @var ConvertDataToRegionInterface
     */
    private $convertDataToRegion;

    /**
     * @var ConvertRegionToDataInterface
     */
    private $convertRegionToData;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Initialize provider
     *
     * @param RegionResource $resource
     * @param ValidateRegionInterface $validateRegion
     * @param ConvertDataToRegionInterface $convertDataToRegion
     * @param ConvertRegionToDataInterface $convertRegionToData
     * @param LoggerInterface $logger
     */
    public function __construct(
        RegionResource $resource,
        ValidateRegionInterface $validateRegion,
        ConvertDataToRegionInterface $convertDataToRegion,
        ConvertRegionToDataInterface $convertRegionToData,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->validateRegion = $validateRegion;
        $this->convertDataToRegion = $convertDataToRegion;
        $this->convertRegionToData = $convertRegionToData;
        $this->logger = $logger;
    }

    /**
     * Save region
     *
     * @param RegionInterface $region
     * @return RegionInterface
     * @throws CouldNotSaveException
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): RegionInterface
    {
        $this->validateRegion->execute($region);
        /** @var \Eriocnemis\Region\Model\Region $model */
        $model = $this->convertDataToRegion->execute($region);
        try {
            $this->resource->save($model);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not save the region with id: %1', $region->getId())
            );
        }
        return $this->convertRegionToData->execute($model);
    }
}
