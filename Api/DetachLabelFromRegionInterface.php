<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Detach labels from region
 *
 * @api
 */
interface DetachLabelFromRegionInterface
{
    /**
     * Detach labels
     *
     * @param int $regionId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $regionId): void;
}
