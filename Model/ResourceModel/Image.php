<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Image
 *
 * @package Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel
 */
class Image extends AbstractDb
{
    /**
     * @inheritdoc
     * @noinspection MagicMethodsValidityInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    protected function _construct()
    {
        $this->_init('hryvinskyi_seo_image_cron_list', 'entity_id');
    }

    /**
     * Add image to cron list
     */
    public function addImages(array $imageUrls): void
    {
        $this->getConnection()->insertOnDuplicate($this->getMainTable(), $imageUrls);
    }
}
