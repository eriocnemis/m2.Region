<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\Region\Api\GetLabelsByRegionIdsInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;
use Eriocnemis\RegionApi\Api\Data\LabelInterface;

/**
 * Get labels by region ids
 */
class GetLabelsByRegionIds implements GetLabelsByRegionIdsInterface
{
    /**
     * Region name relation table name
     */
    private const TABLE_NAME = 'directory_country_region_name';

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize resource
     *
     * @param ResourceConnection $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * Retrieve labels
     *
     * @param int[] $regionIds
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(array $regionIds): array
    {
        $labels = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                [RegionInterface::REGION_ID, LabelInterface::LOCALE, LabelInterface::NAME]
            )->where(RegionInterface::REGION_ID . ' IN (?)', $regionIds);

            $result = $connection->fetchAll($select);
            if ($result) {
                foreach ($result as $data) {
                    $regionId = $data[RegionInterface::REGION_ID];
                    $locale = $data[LabelInterface::LOCALE];
                    $labels[$regionId][$locale] = $data[LabelInterface::NAME];
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve labels by region ids')
            );
        }
        return $labels;
    }
}
