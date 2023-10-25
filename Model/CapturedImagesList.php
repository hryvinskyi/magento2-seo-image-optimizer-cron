<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class CapturedImagesList
{
    private array $capturedImages = [];

    private StoreManagerInterface $storeManager;
    private DirectoryList $directoryList;

    public function __construct(
        StoreManagerInterface $storeManager,
        DirectoryList $directoryList
    ) {
        $this->storeManager = $storeManager;
        $this->directoryList = $directoryList;
    }

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
        $inputPath = $this->convertAbsolutePathToRelativePath($inputPath);
        $outputFile = $this->convertAbsolutePathToRelativePath($outputFile);
        $inputPath = $this->convertAbsoluteUrlToRelativePath($inputPath);
        $outputFile = $this->convertAbsoluteUrlToRelativePath($outputFile);

        $this->capturedImages[] = [
            ImageInterface::SOURCE_IMAGE_PATH => $inputPath,
            ImageInterface::RESULT_IMAGE_PATH => $outputFile,
            ImageInterface::IMAGE_TYPE => $imageType,
            ImageInterface::IS_OPTIMIZED => 0
        ];
    }

    /**
     * Convert an absolute path to a relative path.
     *
     * @param string $path The absolute path.
     * @return string The relative path.
     */
    private function convertAbsolutePathToRelativePath(string $path): string
    {
        $basePath = $this->directoryList->getRoot(); // Gets the Magento root directory.

        // Remove the base path from the absolute path.
        return str_replace($basePath, '/', $path);
    }

    /**
     * Converts an absolute URL to a relative path.
     *
     * @param string $url The absolute URL to convert.
     * @return string The relative path.
     */
    private function convertAbsoluteUrlToRelativePath(string $url): string
    {
        // If you need the base URL, you can get it from the store configuration.
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        // Remove the base URL from the absolute URL.
        // check double sleash
        return str_replace('//', '/', str_replace($baseUrl, '/', $url));
    }
}
