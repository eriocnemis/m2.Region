<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\Region\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\Region\Model\ResourceModel\Region as RegionResource;

/**
 * Region model
 */
class Region extends AbstractModel
{
    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_region';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'region';

    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RegionResource::class);
    }
}
