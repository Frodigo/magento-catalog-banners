<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;

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
                'value' => 0,
                'label' => __('Disabled')
            ],
            [
                'value' => 1,
                'label' => __('Enabled'),
            ]

        ];
    }
}
