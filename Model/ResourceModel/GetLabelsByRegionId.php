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
use Eriocnemis\Region\Api\GetLabelsByRegionIdInterface;
use Eriocnemis\RegionApi\Api\Data\LabelInterface;

/**
 * Get labels by region id
 */
class GetLabelsByRegionId implements GetLabelsByRegionIdInterface
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
     * @param int $regionId
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(int $regionId): array
    {
        $labels = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                [LabelInterface::LOCALE, LabelInterface::NAME]
            )->where('region_id = ?', (string)$regionId);

            $result = $connection->fetchPairs($select);
            if ($result) {
                $labels = $result;
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve labels by region with id %id', ['id' => $regionId])
            );
        }
        return $labels;
    }
}
