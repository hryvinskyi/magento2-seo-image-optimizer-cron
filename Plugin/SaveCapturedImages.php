<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Plugin;

use Hryvinskyi\SeoImageOptimizerApi\Model\ImageParserInterface;
use Hryvinskyi\SeoImageOptimizerCron\Api\ImageRepositoryInterface;
use Hryvinskyi\SeoImageOptimizerCron\Model\CapturedImagesList;
use Hryvinskyi\SeoImageOptimizerCron\Model\Config;
use Magento\Framework\Exception\CouldNotSaveException;

class SaveCapturedImages
{
    private CapturedImagesList $capturedImagesList;
    private ImageRepositoryInterface $imageRepository;
    private Config $config;

    public function __construct(CapturedImagesList $capturedImagesList, ImageRepositoryInterface $imageRepository, Config $config)
    {
        $this->capturedImagesList = $capturedImagesList;
        $this->imageRepository = $imageRepository;
        $this->config = $config;
    }

    /**
     * @param ImageParserInterface $subject
     * @param string $content
     * @return array
     * @throws CouldNotSaveException
     */
    public function afterExecute(ImageParserInterface $subject, string $result): string
    {
        if (!$this->config->isEnabled()) {
            return $result;
        }

        $capturedImages = $this->capturedImagesList->get();

        if (count($capturedImages) > 0) {
            $this->imageRepository->addImagesToList($capturedImages);
        }

        return $result;
    }
}