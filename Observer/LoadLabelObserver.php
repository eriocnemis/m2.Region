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
use Eriocnemis\Region\Api\GetLabelsByRegionIdInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Load labels observer
 */
class LoadLabelObserver implements ObserverInterface
{
    /**
     * @var GetLabelsByRegionIdInterface
     */
    private $getLabelsByRegionId;

    /**
     * Initialize observer
     *
     * @param GetLabelsByRegionIdInterface $getLabelsByRegionId
     */
    public function __construct(
        GetLabelsByRegionIdInterface $getLabelsByRegionId
    ) {
        $this->getLabelsByRegionId = $getLabelsByRegionId;
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
        $region = $observer->getEvent()->getData('region');
        if ($region->getId()) {
            if (!$region->hasData(RegionInterface::LABELS)) {
                $labels = $this->getLabelsByRegionId->execute((int)$region->getId());
                $region->setData(RegionInterface::LABELS, $labels);
            }
        }
    }
}
