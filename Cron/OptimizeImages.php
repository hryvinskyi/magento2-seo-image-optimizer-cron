<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Cron;


use Hryvinskyi\SeoImageOptimizerApi\Model\Convertor\ConvertorListing;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\ImageRepositoryInterface;
use Hryvinskyi\SeoImageOptimizerCron\Model\Config;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;

class OptimizeImages
{
    private ImageRepositoryInterface $imageRepository;
    private ConvertorListing $convertorListing;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private Config $config;

    public function __construct(
        ImageRepositoryInterface $imageRepository,
        ConvertorListing $convertorListing,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Config $config
    ) {
        $this->imageRepository = $imageRepository;
        $this->convertorListing = $convertorListing;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->config = $config;
    }

    /**
     * Cronjob Description
     *
     * @return void
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function execute(): void
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $convertors = [];
        foreach ($this->convertorListing->getConvertors() as $convertor) {
            $convertors[$convertor->imageType()] = $convertor;
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(ImageInterface::IS_OPTIMIZED, 0)
            ->setPageSize(500)
            ->setCurrentPage(1)
            ->create();

        $images = $this->imageRepository->getList($searchCriteria)->getItems();

        foreach ($images as $image) {
            if (isset($convertors[$image->getImageType()])) {
                $result = $convertors[$image->getImageType()]->convert(
                    $image->getSourceImagePath(),
                    $image->getResultImagePath()
                );

                $image->setIsOptimized(1);

                $this->imageRepository->save($image);
            }
        }
    }
}
