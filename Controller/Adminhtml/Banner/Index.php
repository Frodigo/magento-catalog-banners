<?php
declare(strict_types=1);
/**
 * @copyright Copyright (C) 2020 Marcin Kwiatkowski (http://marcin-kwiatkowski.com)
 */
namespace Mkwiatkowski\CatalogBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action implements HttpGetActionInterface
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
    const MENU_ID = 'Mkwiatkowski_CatalogBanners::banners_index';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->resultPageFactory = $pageFactory;

        parent::__construct($context);
    }

    /**
     * Execute.
     *
     * @return Page
     */
    public function execute() : Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Catalog Banners list'));
        return $resultPage;
    }
}