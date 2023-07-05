<?php
/**
 * Copyright (c) 2023. MageCloud.  All rights reserved.
 * @author: Volodymyr Hryvinskyi <mailto:volodymyr@hryvinskyi.com>
 */

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const XML_PATH_ENABLED = 'hryvinskyi_seo/image_optimizer/enabled_by_cron';

    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::XML_PATH_ENABLED);
    }
}