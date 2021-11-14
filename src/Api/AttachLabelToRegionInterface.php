<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Attach labels to region interface
 *
 * @api
 */
interface AttachLabelToRegionInterface
{
    /**
     * Attach labels
     *
     * @param mixed[] $labels
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $labels, int $regionId): void;
}
