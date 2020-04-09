<?php
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
declare(strict_types=1);

namespace Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Form
 * @package Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner
 */
class Form extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mkwiatkowski_CatalogBanners::banner';

    /**
     * Menu identifier
     */
    const MENU_ID = 'Mkwiatkowski_CatalogBanners::banners_add';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Add constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Load the page.
     *
     * @return Page
     */
    public function execute() : Page
    {
        $pageTitle = ($this->getRequest()->getParam('banner_id')) ? __('Edit banner') : __('Add new banner');
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}
