<?php declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Api\Data;

/**
 * Interface BannerInterface
 * @package Mkwiatkowski\CatalogBanners\Api\Data
 * @api
 */
interface BannerInterface
{
    /**
     * Constants for getters and setters
     */
    const BANNER_ID = 'banner_id';
    const CATEGORY_ID = 'category_id';
    const IS_ACTIVE = 'is_active';
    const CONTENT = 'content';

    /**
     * Get banner id
     *
     * @return int
     */
    public function getId();

    /**
     * Get Category Id
     *
     * @return int|null
     */
    public function getCategoryId(): ?int;

    /**
     * Is banner active
     *
     * @return bool|null
     */
    public function isActive(): ?bool;

    /**
     * Get Content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Set ID.
     *
     * @param int $value
     * @return BannerInterface
     */
    public function setId($value);

/**
 * Set category Id
 *
 * @param int $categoryId
 * @return BannerInterface
 */
public function setCategoryId(int $categoryId): BannerInterface;

    /**
     * Set is active
     *
     * @param bool $isActive
     * @return BannerInterface
     */
    public function setIsActive(bool $isActive): BannerInterface;

    /**
     * Set banner content
     *
     * @param string $content
     * @return BannerInterface
     */
    public function setContent(string $content): BannerInterface;
}
