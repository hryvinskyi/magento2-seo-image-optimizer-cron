<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class CapturedImagesList
{
    private array $capturedImages = [];

    private StoreManagerInterface $storeManager;
    private DirectoryList $directoryList;
    private ResourceConnection $resourceConnection;
    private ?array $images = null;

    public function __construct(
        StoreManagerInterface $storeManager = null,
        DirectoryList $directoryList = null,
        ResourceConnection $resourceConnection = null
    ) {
        $this->storeManager = $storeManager ?? \Magento\Framework\App\ObjectManager::getInstance()->get(StoreManagerInterface::class);
        $this->directoryList = $directoryList ?? \Magento\Framework\App\ObjectManager::getInstance()->get(DirectoryList::class);
        $this->resourceConnection = $resourceConnection ?? \Magento\Framework\App\ObjectManager::getInstance()->get(ResourceConnection::class);
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

        $images = $this->getImages();

        if (isset($images[$inputPath])) {
            return;
        }

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
        $baseUrls = [];
        foreach ($this->storeManager->getStores() as $store) {
            $baseUrls[] = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $baseUrls[] = $store->getBaseUrl(UrlInterface::URL_TYPE_STATIC);
        }

        // Remove the base URL from the absolute URL.
        // check double sleash
        return str_replace('//', '/', str_replace($baseUrls, '/pub/media/', $url));
    }

    /**
     * Retrieves the images from the database.
     *
     * @return array The images as an associative array where the keys are the source image paths and the values are also the source image paths.
     */
    private function getImages(): array
    {
        if ($this->images === null) {
            $connection = $this->resourceConnection->getConnection();
            $tableName = $this->resourceConnection->getTableName('hryvinskyi_seo_image_cron_list');
            $select = $connection->select()->from($tableName, ['source_image_path', 'result_image_path']);
            $this->images = $connection->fetchPairs($select);
        }

        return $this->images;
    }
}
