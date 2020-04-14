<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Ui\Component\Listing\Column;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Category
 */
class Category extends Column
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * Category constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CategoryRepositoryInterface $categoryRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Prepare data source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource) : array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['banner_id'])) {
                    try {
                        $category = $this->categoryRepository->get($item['category_id']);
                        $item[$this->getData('name')] = $category->getName();
                    } catch (NoSuchEntityException $e) {
                    }

                }
            }
        }

        return $dataSource;
    }
}
