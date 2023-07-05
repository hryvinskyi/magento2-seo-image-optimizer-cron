<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Api\Data;

/**
 * Interface ImageInterface
 *
 * The ImageInterface provides methods to get and set image properties.
 */
interface ImageInterface
{
    /**#@+
     * Constants for keys of data array.
     */
    public const ENTITY_ID = 'entity_id';
    public const SOURCE_IMAGE_PATH = 'source_image_path';
    public const RESULT_IMAGE_PATH = 'result_image_path';
    public const IMAGE_TYPE = 'image_type';
    public const IS_OPTIMIZED = 'is_optimized';
    /**#@-*/

    /**
     * Get SourceImage value
     *
     * @return string|null
     */
    public function getSourceImagePath(): ?string;

    /**
     * Set SourceImage value
     *
     * @param string $sourceImage
     *
     * @return $this
     */
    public function setSourceImagePath(string $sourceImage): ImageInterface;

    /**
     * Get ResultImagePart value
     *
     * @return string|null
     */
    public function getResultImagePath(): ?string;


    /**
     * Set ResultImagePart value
     *
     * @param string $resultImagePart
     *
     * @return $this
     */
    public function setResultImagePath(string $resultImagePart): ImageInterface;

    /**
     * Get Image type/ value
     *
     * @return string|null
     */
    public function getImageType(): ?string;


    /**
     * Set Image type value
     *
     * @param string $imageType
     *
     * @return $this
     */
    public function setImageType(string $imageType): ImageInterface;

    /**
     * Get IsOptimized value
     *
     * @return int|null
     */
    public function getIsOptimized(): ?int;

    /**
     * Set IsOptimized value
     *
     * @param int $isOptimized
     *
     * @return $this
     */
    public function setIsOptimized(int $isOptimized): ImageInterface;
}
