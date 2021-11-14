<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\Region\Api\ConvertDataToRegionInterface;
use Eriocnemis\Region\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Region\Model\RegionFactory;

/**
 * Convert data to region model
 */
class ConvertDataToRegion implements ConvertDataToRegionInterface
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
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * Initialize converter
     *
     * @param RegionResource $resource
     * @param DataObjectProcessor $dataObjectProcessor
     * @param RegionFactory $factory
     */
    public function __construct(
        RegionResource $resource,
        DataObjectProcessor $dataObjectProcessor,
        RegionFactory $factory
    ) {
        $this->resource = $resource;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->factory = $factory;
    }

    /**
     * Convert to model
     *
     * @param RegionInterface $region
     * @return AbstractModel
     */
    public function execute(RegionInterface $region): AbstractModel
    {
        /** @var \Eriocnemis\Region\Model\Region $model */
        $model = $this->factory->create();
        if ($region->getId()) {
            $this->resource->load($model, $region->getId(), RegionInterface::REGION_ID);
        }

        $data = $this->dataObjectProcessor->buildOutputDataArray($region, RegionInterface::class);
        $model->addData($data);
        /* translate labels into arrays */
        $labels = [];
        foreach ($region->getLabels() as $label) {
            $labels[$label->getLocale()] = $label->getName();
        }
        $model->setData(RegionInterface::LABELS, $labels);

        return $model;
    }
}
