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
 * Convert region model to data interface
 *
 * @api
 */
interface ConvertRegionToDataInterface
{
    /**
     * Convert to data
     *
     * @param AbstractModel $model
     * @return RegionInterface
     */
    public function execute(AbstractModel $model): RegionInterface;
}
