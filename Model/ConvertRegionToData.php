<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterfaceFactory;
use Eriocnemis\RegionApi\Api\Data\LabelInterface;
use Eriocnemis\RegionApi\Api\Data\LabelInterfaceFactory;
use Eriocnemis\RegionApi\Api\Data\RegionExtensionFactory;
use Eriocnemis\Region\Api\ConvertRegionToDataInterface;

/**
 * Convert region model to data
 */
class ConvertRegionToData implements ConvertRegionToDataInterface
{
    /**
     * @var RegionInterfaceFactory
     */
    private $regionDataFactory;

    /**
     * @var LabelInterfaceFactory
     */
    private $labelDataFactory;

    /**
     * @var RegionExtensionFactory
     */
    private $extensionFactory;

    /**
     * Initialize converter
     *
     * @param RegionInterfaceFactory $regionDataFactory
     * @param LabelInterfaceFactory $labelDataFactory
     * @param RegionExtensionFactory $extensionFactory
     */
    public function __construct(
        RegionInterfaceFactory $regionDataFactory,
        LabelInterfaceFactory $labelDataFactory,
        RegionExtensionFactory $extensionFactory
    ) {
        $this->regionDataFactory = $regionDataFactory;
        $this->labelDataFactory = $labelDataFactory;
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * Convert to data
     *
     * @param AbstractModel $model
     * @return RegionInterface
     */
    public function execute(AbstractModel $model): RegionInterface
    {
        $data = $this->convertExtensionAttributesToObject($model->getData());
        $region = $this->regionDataFactory->create(['data' => $data]);
        /* translate labels into objects */
        if ($region->getLabels()) {
            $labels = [];
            foreach ($region->getLabels() as $locale => $name) {
                $data = [LabelInterface::LOCALE => $locale, LabelInterface::NAME => $name];
                $labels[] = $this->labelDataFactory->create(['data' => $data]);
            }
            $region->setLabels($labels);
        }
        return $region;
    }

    /**
     * Convert extension attributes of model to object if it is an array
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    private function convertExtensionAttributesToObject(array $data)
    {
        if (isset($data['extension_attributes']) && is_array($data['extension_attributes'])) {
            $data['extension_attributes'] = $this->extensionFactory->create(['data' => $data['extension_attributes']]);
        }
        return $data;
    }
}
