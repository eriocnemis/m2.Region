<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model\Data;

use Magento\Framework\Api\SearchResults;
use Eriocnemis\RegionApi\Api\Data\RegionSearchResultInterface;

/**
 * Region search result
 *
 * @api
 */
class RegionSearchResult extends SearchResults implements RegionSearchResultInterface
{
}
