<?php
/**
 * Copyright (c) 2023. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\DB\Adapter\DeadlockException;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Class Image
 *
 * @package Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel
 */
class Image extends AbstractDb
{
    private int $maxRetryCount = 10;

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
        for ($tries = 0; ; $tries++) {
            $this->getConnection()->beginTransaction();

            try {
                $this->getConnection()->insertOnDuplicate(
                    $this->getMainTable(),
                    $imageUrls,
                    [ImageInterface::SOURCE_IMAGE_PATH, ImageInterface::RESULT_IMAGE_PATH]
                );
                $this->getConnection()->commit();
            } catch (DeadlockException $deadlockException) {
                $this->getConnection()->rollBack();
                if ($tries >= $this->maxRetryCount) {
                    throw $deadlockException;
                }
                continue;
            } catch (\Exception $e) {
                $this->getConnection()->rollBack();
                throw $e;
            }

            break;
        }
    }
}
