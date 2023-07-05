<?php
/**
 * Copyright (c) 2021. MageCloud. All rights reserved.
 * @author: Volodymyr Hryvinskyi <volodymyr@hryvinskyi.com>
 */

declare(strict_types=1);

namespace Hryvinskyi\SeoImageOptimizerCron\Model;

use Magento\Framework\Api\Search\SearchResult;
use Hryvinskyi\SeoImageOptimizerCron\Api\Data\ImageSearchResultsInterface;

/**
 * Class ImageSearchResults
 */
class ImageSearchResults extends SearchResult implements ImageSearchResultsInterface
{
    /**
     * @inheritdoc
     */
    public function getItems(): array
    {
        return parent::getItems() ?? [];
    }

    /**
     * @inheritdoc
     */
    public function setItems(?array $items = null): ImageSearchResultsInterface
    {
        $this->setData(self::ITEMS, $items);

        return $this;
    }
}
