<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResult;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\ValidateRegionInterface;
use Eriocnemis\Region\Model\Region\ValidatorInterface;

/**
 * Validate region data
 *
 * @api
 */
class ValidateRegion implements ValidateRegionInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Initialize provider
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * Validate region
     *
     * @param RegionInterface $region
     * @return bool
     * @throws ValidationException
     */
    public function execute(RegionInterface $region): bool
    {
        /** @var ValidationResult $result */
        $result = $this->validator->validate($region);
        if (!$result->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $result);
        }
        return true;
    }
}
