<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image as ImageResource;
use Magento\Framework\Model\AbstractModel;

/**
 * @method ImageResource getResource()
 * @method \Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image\Collection getCollection()
 * @method \Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image\Collection getResourceCollection()
 */
class Image extends AbstractModel implements ImageInterface
{
    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'hryvinskyi_seo_image_optimizer_cron_model_image';

    /**
     * @inheritdoc
     * @noinspection MagicMethodsValidityInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    protected function _construct()
    {
        $this->_init(ImageResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getSourceImagePath(): ?string
    {
        return $this->_getData(self::SOURCE_IMAGE_PATH) === null ? null :
            (string)$this->_getData(self::SOURCE_IMAGE_PATH);
    }

    /**
     * @inheritdoc
     */
    public function setSourceImagePath(string $sourceImage): ImageInterface
    {
        $this->setData(self::SOURCE_IMAGE_PATH, $sourceImage);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResultImagePath(): ?string
    {
        return $this->_getData(self::RESULT_IMAGE_PATH) === null ? null :
            (string)$this->_getData(self::RESULT_IMAGE_PATH);
    }

    /**
     * @inheritdoc
     */
    public function setResultImagePath(string $resultImagePart): ImageInterface
    {
        $this->setData(self::RESULT_IMAGE_PATH, $resultImagePart);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImageType(): ?string
    {
        return $this->_getData(self::IMAGE_TYPE) === null ? null :
            (string)$this->_getData(self::IMAGE_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function setImageType(string $imageType): ImageInterface
    {
        $this->setData(self::IMAGE_TYPE, $imageType);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getIsOptimized(): ?int
    {
        return $this->_getData(self::IS_OPTIMIZED) === null ? null :
            (int)$this->_getData(self::IS_OPTIMIZED);
    }

    /**
     * @inheritdoc
     */
    public function setIsOptimized(int $isOptimized): ImageInterface
    {
        $this->setData(self::IS_OPTIMIZED, $isOptimized);

        return $this;
    }
}
