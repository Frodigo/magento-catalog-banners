<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Model\Banner;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProviderInterface;
use Mkwiatkowski\CatalogBanners\Model\Banner;
use Mkwiatkowski\CatalogBanners\Model\BannerFactory;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as MagentoDataProvider;
use Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner\Collection;

/**
 * Class DataProvider
 * @package Mkwiatkowski\CatalogBanners\Model\Banner
 */
class DataProvider extends MagentoDataProvider implements DataProviderInterface
{
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @var BannerFactory
     */
    private $bannerFactory;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param BannerFactory $bannerFactory
     * @param Collection $collection
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        BannerFactory $bannerFactory,
        Collection $collection,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->collection = $collection;
        $this->dataPersistor = $dataPersistor;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * Get data.
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData() : array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        /** @var Banner $banner */
        foreach ($items as $banner) {
            $this->loadedData[$banner->getId()] = $banner->getData();
        }

        $data = $this->dataPersistor->get('catalog_banner');
        
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();
            $this->dataPersistor->clear('catalog_banner');
        }

        return $this->loadedData;
    }
}
