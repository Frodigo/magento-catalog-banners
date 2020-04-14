<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;
use Mkwiatkowski\CatalogBanners\Api\BannerRepositoryInterface;
use Mkwiatkowski\CatalogBanners\Api\Data\BannerInterface;
use Mkwiatkowski\CatalogBanners\Model\Banner;

/**
 * Class InlineEdit
 */
class InlineEdit extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mkwiatkowski_CatalogBanners::banner';

    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * InlineEdit constructor.
     *
     * @param Context $context
     * @param BannerRepositoryInterface $bannerRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        BannerRepositoryInterface $bannerRepository,
        JsonFactory $jsonFactory
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->jsonFactory = $jsonFactory;

        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return Json
     */
    public function execute() : Json
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $bannerId) {
                    try {
                        /** @var Banner $banner */
                        $banner = $this->bannerRepository->getById($bannerId);
                        $banner->setData(array_merge($banner->getData(), $postItems[$bannerId]));
                        $this->bannerRepository->save($banner);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithBannerId(
                            $banner,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add banner title to error message
     *
     * @param BannerInterface $banner
     * @param string $errorText
     * @return string
     */
    private function getErrorWithBannerId(BannerInterface $banner, $errorText) : string
    {
        return '[Banner ID: ' . $banner->getId() . '] ' . $errorText;
    }
}
