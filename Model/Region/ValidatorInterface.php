<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\Region;

use Magento\Framework\Validation\ValidationResult;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Extension point for base validation of region
 *
 * @api
 */
interface ValidatorInterface
{
    /**
     * Validate region attribute values
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult;
}
