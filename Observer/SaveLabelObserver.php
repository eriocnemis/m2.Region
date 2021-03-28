<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\Region\Api\DetachLabelFromRegionInterface;
use Eriocnemis\Region\Api\AttachLabelToRegionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Save labels observer
 */
class SaveLabelObserver implements ObserverInterface
{
    /**
     * @var DetachLabelFromRegionInterface
     */
    private $detachLabelFromRegion;

    /**
     * @var AttachLabelToRegionInterface
     */
    private $attachLabelToRegion;

    /**
     * Initialize observer
     *
     * @param DetachLabelFromRegionInterface $detachLabelFromRegion
     * @param AttachLabelToRegionInterface $attachLabelToRegion
     */
    public function __construct(
        DetachLabelFromRegionInterface $detachLabelFromRegion,
        AttachLabelToRegionInterface $attachLabelToRegion
    ) {
        $this->detachLabelFromRegion = $detachLabelFromRegion;
        $this->attachLabelToRegion = $attachLabelToRegion;
    }

    /**
     * Save labels
     *
     * @param Observer $observer
     * @return void
     * @throws CouldNotSaveException
     * @throws CouldNotDeleteException
     */
    public function execute(Observer $observer): void
    {
        $region = $observer->getEvent()->getData('region');
        if ($region->getId()) {
            $labels = $region->hasData(RegionInterface::LABELS)
                ? $region->getData(RegionInterface::LABELS)
                : [];
            $this->detachLabelFromRegion->execute((int)$region->getId());
            $this->attachLabelToRegion->execute($labels, (int)$region->getId());
        }
    }
}
