<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get labels by region ids interface
 *
 * @api
 */
interface GetLabelsByRegionIdsInterface
{
    /**
     * Retrieve labels
     *
     * @param int[] $regionIds
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(array $regionIds): array;
}
