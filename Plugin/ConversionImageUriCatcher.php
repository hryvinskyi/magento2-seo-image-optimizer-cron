<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Plugin;

use Hryvinskyi\SeoImageOptimizerApi\Model\Convertor\ConvertorInterface;
use Hryvinskyi\SeoImageOptimizerCron\Model\CapturedImagesList;
use Hryvinskyi\SeoImageOptimizerCron\Model\Config;

class ConversionImageUriCatcher
{
    private CapturedImagesList $capturedImagesList;
    private Config $config;

    public function __construct(CapturedImagesList $capturedImagesList, Config $config)
    {
        $this->capturedImagesList = $capturedImagesList;
        $this->config = $config;
    }

    /**
     * This plugin cathing image uri and save it to list.
     * And prevent converting image on frontend part.
     *
     * @param ConvertorInterface $subject
     * @param \Closure $closure
     * @param string $inputPath
     * @param string $outputPath
     * @return string
     */
    public function aroundConvert(
        ConvertorInterface $subject,
        \Closure $closure,
        string $inputPath,
        string $outputPath
    ): string {
        if (!$this->config->isEnabled()) {
            return $closure($inputPath, $outputPath);
        }

        $this->capturedImagesList->add($inputPath, $outputPath, $subject->imageType());

        return $inputPath;
    }
}