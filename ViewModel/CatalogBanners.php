<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\ViewModel;

use Magento\Catalog\Model\Layer\Resolver;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Mkwiatkowski\CatalogBanners\Api\BannerRepositoryInterface;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CatalogBanners
 */
class CatalogBanners implements ArgumentInterface
{
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Resolver
     */
    private $resolver;
    /**
     * @var FilterProvider
     */
    private $filterProvider;

    /**
     * CatalogBanners constructor.
     * @param BannerRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param LoggerInterface $logger
     * @param Resolver $resolver
     * @param FilterProvider $filterProvider
     */
    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        LoggerInterface $logger,
        Resolver $resolver,
        FilterProvider $filterProvider
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger = $logger;
        $this->resolver = $resolver;
        $this->filterProvider = $filterProvider;
    }

    /**
     * Get random banner for current category.
     *
     * @return string[]|null
     */
    public function getBannersForCurrentCategory() : ?array
    {
        $currentCategory = $this->resolver->get()->getCurrentCategory();
        $bannersOutput = [];

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(BannerInterface::CATEGORY_ID, $currentCategory->getId())
            ->addFilter(BannerInterface::IS_ACTIVE, BannerInterface::STATUS_ENABLED)
            ->create();

        try {
            $banners = $this->bannerRepository->getList($searchCriteria)->getItems();

            foreach ($banners as $banner) {
                $bannersOutput[] = $this->filterProvider->getBlockFilter()->filter($banner->getContent());
            }

            return $bannersOutput;
        } catch (\Exception $e) {
            $this->logger->notice($e->getMessage());

            return null;
        }
    }
}
