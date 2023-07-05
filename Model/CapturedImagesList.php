<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;

class CapturedImagesList
{
    private array $capturedImages = [];

    /**
     * Get the captured images.
     *
     * @return array The captured images.
     */
    public function get(): array
    {
        return $this->capturedImages;
    }

    /**
     * Add an image path to the captured images array.
     *
     * @param string $inputPath The path of the image to be added.
     * @param string $outputFile The result image path.
     * @param string $imageType
     *
     * @return void
     */
    public function add(string $inputPath, string $outputFile, string $imageType): void
    {
        $this->capturedImages[] = [
            ImageInterface::SOURCE_IMAGE_PATH => $inputPath,
            ImageInterface::RESULT_IMAGE_PATH => $outputFile,
            ImageInterface::IMAGE_TYPE => $imageType,
            ImageInterface::IS_OPTIMIZED => 0
        ];
    }
}