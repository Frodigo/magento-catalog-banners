<?php
namespace Mkwiatkowski\CatalogBanners\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mkwiatkowski\CatalogBanners\Api\BannerRepositoryInterface;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterfaceFactory;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerSearchResultsInterface;
use Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner as BannerResource;
use Magento\Framework\Api\SearchCriteriaInterface;
use Mkwiatkowski\CatalogBanners\Model\ResourceModel\Banner\CollectionFactory;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerSearchResultsInterfaceFactory;

/**
 * Class BannerRepository
 */
class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var BannerResource
     */
    protected $resource;

    /**
     * @var BannerInterfaceFactory
     */
    protected $bannerFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var BannerSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * BannerRepository constructor.
     *
     * @param BannerResource $resource
     * @param BannerInterfaceFactory $bannerFactory
     * @param CollectionFactory $collectionFactory
     * @param BannerSearchResultsInterfaceFactory $bannerSearchResultsInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        BannerResource $resource,
        BannerInterfaceFactory $bannerFactory,
        CollectionFactory $collectionFactory,
        BannerSearchResultsInterfaceFactory $bannerSearchResultsInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->bannerFactory = $bannerFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $bannerSearchResultsInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save banner.
     *
     * @param BannerInterface $banner
     * @return BannerInterface
     * @throws CouldNotSaveException
     */
    public function save(BannerInterface $banner)
    {
        try {
            $this->resource->save($banner);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $banner;
    }

    /**
     * Retrieve banner.
     *
     * @param int $bannerId
     * @return BannerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $bannerId)
    {
        /** @var BannerInterface $banner */
        $banner = $this->bannerFactory->create();
        $this->resource->load($banner, $bannerId);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('The banner with the "%1" ID doesn\'t exist.', $bannerId));
        }

        return $banner;
    }

    /**
     * Retrieve banners matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return BannerSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete banner.
     *
     * @param BannerInterface $banner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(BannerInterface $banner)
    {
        try {
            $this->resource->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete banner by id.
     *
     * @param int $bannerId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $bannerId)
    {
        return $this->delete($this->getById($bannerId));
    }
}
