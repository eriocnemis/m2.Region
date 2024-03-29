<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Eriocnemis\RegionApi\Api\Data\RegionExtensionInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Region data model
 *
 * @api
 */
class Region extends AbstractExtensibleObject implements RegionInterface
{
    /**
     * Retrieve region id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::REGION_ID);
    }

    /**
     * Set region id
     *
     * @param int $regionId
     * @return void
     */
    public function setId($regionId): void
    {
        $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * Retrieve country id
     *
     * @return string
     */
    public function getCountryId(): string
    {
        return (string)$this->_get(self::COUNTRY_ID);
    }

    /**
     * Set country id
     *
     * @param string $countryId
     * @return void
     */
    public function setCountryId($countryId): void
    {
        $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * Retrieve the region code
     *
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this->_get(self::CODE);
    }

    /**
     * Set the region code
     *
     * @param string $code
     * @return void
     */
    public function setCode($code): void
    {
        $this->setData(self::CODE, $code);
    }

    /**
     * Retrieve region default name
     *
     * @return string
     */
    public function getDefaultName(): string
    {
        return (string)$this->_get(self::DEFAULT_NAME);
    }

    /**
     * Set region default name
     *
     * @param string $name
     * @return void
     */
    public function setDefaultName($name): void
    {
        $this->setData(self::DEFAULT_NAME, $name);
    }

    /**
     * Retrieve the region labels
     *
     * @return \Eriocnemis\RegionApi\Api\Data\LabelInterface[]
     */
    public function getLabels(): array
    {
        return (array)$this->_get(self::LABELS) ?: [];
    }

    /**
     * Set the region labels
     *
     * @param \Eriocnemis\RegionApi\Api\Data\LabelInterface[] $labels
     * @return void
     */
    public function setLabels($labels): void
    {
        $this->setData(self::LABELS, $labels);
    }

    /**
     * Retrieve the region status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->_get(self::STATUS);
    }

    /**
     * Set the region status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status): void
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * Retrieve existing extension attributes object or create a new one
     *
     * @return \Eriocnemis\RegionApi\Api\Data\RegionExtensionInterface
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object
     *
     * @param \Eriocnemis\RegionApi\Api\Data\RegionExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(RegionExtensionInterface $extensionAttributes): void
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
