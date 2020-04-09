<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 * @package Mkwiatkowski\CatalogBanners\Block\Adminhtml\Edit
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []) : string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}