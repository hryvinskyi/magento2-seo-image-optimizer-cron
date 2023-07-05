<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image;

use Hryvinskyi\SeoImageOptimizerCron\Model\Image as ImageModel;
use Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image as ImageResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @method ImageResource getResource()
 * @method ImageModel[] getItems()
 * @method ImageModel[] getItemsByColumnValue($column, $value)
 * @method ImageModel getFirstItem()
 * @method ImageModel getLastItem()
 * @method ImageModel getItemByColumnValue($column, $value)
 * @method ImageModel getItemById($idValue)
 * @method ImageModel getNewEmptyItem()
 * @method ImageModel fetchItem()
 * @property ImageModel[] _items
 * @property ImageResource _resource
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'hryvinskyi_seo_image_optimizer_cron_image_collection';

    /**
     * @inheritdoc
     */
    protected $_eventObject = 'object';

    /**
     * @inheritdoc
     * @noinspection MagicMethodsValidityInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _construct()
    {
        $this->_init(ImageModel::class, ImageResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
