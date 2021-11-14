<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Api;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Convert data to region model interface
 *
 * @api
 */
interface ConvertDataToRegionInterface
{
    /**
     * Convert to model
     *
     * @param RegionInterface $region
     * @return AbstractModel
     */
    public function execute(RegionInterface $region): AbstractModel;
}
