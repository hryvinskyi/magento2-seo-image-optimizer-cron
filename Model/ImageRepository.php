<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Hryvinskyi\SeoImageOptimizerCron\Api\ImageRepositoryInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterfaceFactory;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageSearchResultsInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageSearchResultsInterfaceFactory;
use Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image as ImageResource;
use Hryvinskyi\SeoImageOptimizerCron\Model\ResourceModel\Image\CollectionFactory;

/**
 * Class ImageRepository
 */
class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @var ImageResource
     */
    private $resource;

    /**
     * @var ImageInterfaceFactory
     */
    private $entityFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ImageSearchResultsInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * ImageRepository constructor.
     *
     * @param ImageResource $resource
     * @param ImageInterfaceFactory $imageFactory
     * @param CollectionFactory $collectionFactory
     * @param ImageSearchResultsInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ImageResource $resource,
        ImageInterfaceFactory $imageFactory,
        CollectionFactory $collectionFactory,
        ImageSearchResultsInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->entityFactory = $imageFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritdoc
     */
    public function save(ImageInterface $image): ImageInterface
    {
        try {
            $this->resource->save($image);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $image;
    }

    /**
     * @inheritdoc
     */
    public function getBySourceImage(string $sourceImage): ImageInterface
    {
        $image = $this->entityFactory->create();
        $this->resource->load($image, $sourceImage, ImageInterface::SOURCE_IMAGE_PATH);
        if (!$image->getId()) {
            throw new NoSuchEntityException(__('Image with path "%1" does not exist.', $sourceImage));
        }

        return $image;
    }

    /**
     * @inheritdoc
     */
    public function findBySourceImage(string $sourceImage): ?ImageInterface
    {
        $image = $this->entityFactory->create();
        $this->resource->load($image, $sourceImage, ImageInterface::SOURCE_IMAGE_PATH);

        if (!$image->getId()) {
            return null;
        }

        return $image;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ImageSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        return $this->searchResultFactory
            ->create()
            ->setSearchCriteria($searchCriteria)
            ->setItems($collection->getItems())
            ->setTotalCount($collection->getSize());
    }

    /**
     * @param array $sourceImages
     * @return array
     */
    public function addImagesToList(array $sourceImages): array
    {
        $this->resource->addImages($sourceImages);

        return $sourceImages;
    }

    /**
     * @inheritdoc
     */
    public function delete(ImageInterface $image): bool
    {
        try {
            $this->resource->delete($image);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteBySourceImage(string $sourceImage): bool
    {
        return $this->delete($this->getById($sourceImage));
    }
}
