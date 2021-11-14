<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get labels by region id interface
 *
 * @api
 */
interface GetLabelsByRegionIdInterface
{
    /**
     * Retrieve labels
     *
     * @param int $regionId
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(int $regionId): array;
}
