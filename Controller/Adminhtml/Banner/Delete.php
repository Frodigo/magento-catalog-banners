<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Mkwiatkowski\CatalogBanners\Api\BannerRepositoryInterface;

/**
 * Class Delete
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        Context $context,
        BannerRepositoryInterface $bannerRepository
    ) {
        $this->bannerRepository = $bannerRepository;

        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return Redirect
     */
    public function execute() : Redirect
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('banner_id');

        if ($id) {
            try {
                $this->bannerRepository->deleteById((int) $id);
                $this->messageManager->addSuccessMessage(__('You deleted the banner.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
