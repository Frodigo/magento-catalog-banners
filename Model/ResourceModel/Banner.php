<?php declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;

/**
 * Class Banner
 */
class Banner extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct() // @codingStandardsIgnoreLine
    {
        $this->_init('catalog_banners', BannerInterface::BANNER_ID);
    }
}
