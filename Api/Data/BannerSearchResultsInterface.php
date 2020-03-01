<?php
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for banner search results.
 */
interface BannerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface[] $items
     * @return \Mkwiatkowski\CatalogBanners\Api\Data\BannerSearchResultsInterface
     */
    public function setItems(array $items);
}
