<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Region\Api\GetLabelsByRegionIdsInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Load labels observer
 */
class LoadLabelsObserver implements ObserverInterface
{
    /**
     * @var GetLabelsByRegionIdsInterface
     */
    private $getLabelsByRegionIds;

    /**
     * Initialize observer
     *
     * @param GetLabelsByRegionIdsInterface $getLabelsByRegionIds
     */
    public function __construct(
        GetLabelsByRegionIdsInterface $getLabelsByRegionIds
    ) {
        $this->getLabelsByRegionIds = $getLabelsByRegionIds;
    }

    /**
     * Load labels
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        $collection = $observer->getEvent()->getData('collection');
        $regionIds = $collection->getColumnValues(RegionInterface::REGION_ID);
        if (0 < count($regionIds)) {
            $labels = $this->getLabelsByRegionIds->execute($regionIds);
            foreach ($collection as $region) {
                $region->setData(RegionInterface::LABELS, $labels[$region->getId()] ?? []);
            }
        }
    }
}
