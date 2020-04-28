<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{

    /**
     * Get options array.
     *
     * @return array
     */
    public function toOptionArray() : array
    {
        return [
            [
                'value' => BannerInterface::STATUS_DISABLED,
                'label' => __('Disabled')
            ],
            [
                'value' => BannerInterface::STATUS_ENABLED,
                'label' => __('Enabled'),
            ]

        ];
    }
}
