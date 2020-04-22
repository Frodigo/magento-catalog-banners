<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */

namespace Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mkwiatkowski\CatalogBanners\Model\Banner;
use Mkwiatkowski\CatalogBanners\Model\BannerFactory;
use Mkwiatkowski\CatalogBanners\Model\BannerRepository;
use Psr\Log\LoggerInterface;

/**
 * Class Save
 * @package Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mkwiatkowski_CatalogBanners::banners';

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var BannerFactory
     */
    private $bannerFactory;

    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param RedirectFactory $redirectFactory
     * @param BannerFactory $bannerFactory
     * @param BannerRepository $bannerRepository
     * @param LoggerInterface $logger
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        RedirectFactory $redirectFactory,
        BannerFactory $bannerFactory,
        BannerRepository $bannerRepository,
        LoggerInterface $logger,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultRedirectFactory = $redirectFactory;
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
        $this->logger = $logger;
        $this->dataPersistor = $dataPersistor;

        parent::__construct($context);
    }

    /**
     * @return Redirect
     */
    public function execute() : Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (empty($data['banner_id'])) {
                unset($data['banner_id']);
            }

            /** @var Banner $bannerModel */
            $bannerModel = $this->bannerFactory->create();
            $bannerId = (int) $this->getRequest()->getParam('banner_id');

            if ($bannerId) {
                try {
                    $bannerModel = $this->bannerRepository->getById($bannerId);
                } catch (NoSuchEntityException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                    $this->logger->debug($e->getMessage());
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $bannerModel->setData($data);

            try {
                $this->bannerRepository->save($bannerModel);
                $this->messageManager->addSuccessMessage(__('You saved the banner.'));
                $this->dataPersistor->clear('catalog_banner');
                $this->dataPersistor->set('catalog_banner', $data);
                return $resultRedirect->setPath('*/*/form', ['banner_id' => $bannerModel->getId()]);
            } catch (CouldNotSaveException $e) {
                $errorMessage = $e->getMessage();
                $this->messageManager->addErrorMessage($errorMessage);
                $this->logger->error($errorMessage);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
                $this->logger->error($e->getMessage());
            }

            $this->dataPersistor->set('catalog_banner', $data);

            return $resultRedirect->setPath('*/*/form', ['banner_id' => $bannerId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
