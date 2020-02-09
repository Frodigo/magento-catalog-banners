<?php declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;

/**
 * Banner model
 *
 * Class Banner
 * @package Mkwiatkowski\CatalogBanners\Model
 */
class Banner extends AbstractModel implements BannerInterface, IdentityInterface
{
    /**
     * Banner cache tag
     */
    const CACHE_TAG = 'catalog_custom_banner';

    /**
     * Banner event prefix
     */
    const EVENT_PREFIX = 'catalog_custom_banner';

    /**
     * Banner cache tag
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG; // @codingStandardsIgnoreLine

    /**
     * Prefix for model events
     *
     * @var string
     */
    protected $_eventPrefix = self::EVENT_PREFIX; // @codingStandardsIgnoreLine

    /**
     * Id field name
     *
     * @var string
     */
    protected $_idFieldName = self::BANNER_ID; // @codingStandardsIgnoreFile;

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner::class);
    }

    /**
     * Get Category Id
     *
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * Is banner active
     *
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set Category id
     *
     * @param int $categoryId
     * @return BannerInterface
     */
    public function setCategoryId(int $categoryId): BannerInterface
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Set is Banner active
     *
     * @param bool $isActive
     * @return BannerInterface
     */
    public function setIsActive(bool $isActive): BannerInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set Content
     *
     * @param string $content
     * @return BannerInterface
     */
    public function setContent(string $content): BannerInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get identities
     *
     * @return array|string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
