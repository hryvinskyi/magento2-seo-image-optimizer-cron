<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageSearchResultsInterface;

/**
 * Interface ImageRepositoryInterface
 */
interface ImageRepositoryInterface
{
    /**
     * Save Image
     *
     * @param \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface $image
     *
     * @return \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ImageInterface $image): ImageInterface;

    /**
     * Get Image Source Image.
     *
     * @param string $sourceImage
     *
     * @return \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBySourceImage(string $sourceImage): ImageInterface;

    /**
     * Find Image Source Image.
     *
     * @param string $sourceImage
     *
     * @return \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface|null
     */
    public function findBySourceImage(string $sourceImage): ?ImageInterface;

    /**
     * Retrieve Image matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ImageSearchResultsInterface;

    /**
     * Add Images to List
     *
     * @param array $sourceImages
     * @return array
     */
    public function addImagesToList(array $sourceImages): array;
    /**
     * Delete Image
     *
     * @param \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface $image
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ImageInterface $image): bool;

    /**
     * Delete Image by ID.
     *
     * @param string $sourceImage
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteBySourceImage(string $sourceImage): bool;
}
