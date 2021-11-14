<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\Region\Api\AttachLabelToRegionInterface;

/**
 * Attach labels to region
 */
class AttachLabelToRegion implements AttachLabelToRegionInterface
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
     * Attach labels
     *
     * @param mixed[] $labels
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $labels, int $regionId): void
    {
        try {
            $data = [];
            foreach ($labels as $locale => $name) {
                $data[] = [
                    'region_id' => $regionId,
                    'locale' => $locale,
                    'name' => $name
                ];
            }

            if ($data) {
                $this->resource->getConnection()->insertOnDuplicate(
                    $this->resource->getTableName(self::TABLE_NAME),
                    $data
                );
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not attach labels to region with id %id', ['id' => $regionId])
            );
        }
    }
}
