<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\Region\Validator;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\Region\Model\Region\ValidatorInterface;

/**
 * Check that country is valid
 */
class CountryValidator implements ValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var CountryInformationAcquirerInterface
     */
    private $repository;

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param CountryInformationAcquirerInterface $repository
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        CountryInformationAcquirerInterface $repository
    ) {
        $this->validationResultFactory = $validationResultFactory;
        $this->repository = $repository;
    }

    /**
     * Validate country
     *
     * @param RegionInterface $region
     * @return ValidationResult
     */
    public function validate(RegionInterface $region): ValidationResult
    {
        $errors = [];
        $countryId = trim($region->getCountryId());
        if ('' === $countryId) {
            $errors[] = __('Country field is required. Enter and try again.');
        } else {
            try {
                $this->repository->getCountryInfo($countryId);
            } catch (\Exception $e) {
                $errors[] = __('Invalid value of %1 provided for the Country field.', $countryId);
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
