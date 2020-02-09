<?php
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;
use Mkwiatkowski\CatalogBanners\Model\Banner as BannerModel;
use Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner as BannerResourceModel;

/**
 * Collection of banners
 *
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * If field name
     *
     * @var string
     */
    protected $_idFieldName = BannerInterface::BANNER_ID; // @codingStandardsIgnoreLine

    /**
     * Prefix for collection events
     *
     * @var string
     */
    protected $_eventPrefix = 'custom_banners_collection'; // @codingStandardsIgnoreLine

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'custom_banners_collection'; // @codingStandardsIgnoreLine

    /**
     * Construct.
     *
     * @return void
     */
    public function _construct() // @codingStandardsIgnoreLine
    {
        $this->_init(BannerModel::class, BannerResourceModel::class);
    }
}
