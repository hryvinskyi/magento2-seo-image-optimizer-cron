<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ImageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Image list.
     *
     * @return \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface[]
     */
    public function getItems(): array;

    /**
     * Set Image list.
     *
     * @param \Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageInterface[] $items
     *
     * @return $this
     */
    public function setItems(?array $items = null): ImageSearchResultsInterface;
}
