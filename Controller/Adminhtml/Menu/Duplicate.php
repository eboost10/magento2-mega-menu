<?php

declare(strict_types=1);

namespace EBoost\Menu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use EBoost\Menu\Api\MenuRepositoryInterface;
use EBoost\Menu\Controller\Adminhtml\MenuAction;
use EBoost\Menu\Model\MenuFactory;
use EBoost\Menu\Service\Menu\CloneRequestProcessor;

class Duplicate extends MenuAction implements HttpGetActionInterface
{
    /**
     * @inheritDoc
     */
    const ADMIN_RESOURCE = 'EBoost_Menu::menus';

    /**
     * @var CloneRequestProcessor
     */
    private $cloneRequestProcessor;

    public function __construct(
        Context $context,
        MenuRepositoryInterface $menuRepository,
        MenuFactory $menuFactory,
        CloneRequestProcessor $cloneRequestProcessor
    ) {
        $this->cloneRequestProcessor = $cloneRequestProcessor;
        parent::__construct($context, $menuRepository, $menuFactory);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $menu = $this->getCurrentMenu();
        $redirectPath = '*/*';

        if (!$menu->getId()) {
            $this->messageManager->addErrorMessage(__('Cannot duplicate a menu with an invalid ID.'));
            return $resultRedirect->setPath($redirectPath);
        }

        $this->cloneRequestProcessor->clone($menu);

        return $resultRedirect->setPath($redirectPath);
    }
}
