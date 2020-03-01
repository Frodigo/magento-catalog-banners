<?php
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Api;

/**
 * Banner CRUD interface
 */
interface BannerRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface $banner
     * @return \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface $banner);

    /**
     * Retrieve banner.
     *
     * @param int $bannerId
     * @return \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $bannerId);

    /**
     * Retrieve banners matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mkwiatkowski\CatalogBanners\Api\Data\BannerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete banner.
     *
     * @param \Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface $banner);

    /**
     * Delete banner by id.
     *
     * @param int $bannerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $bannerId);
}
