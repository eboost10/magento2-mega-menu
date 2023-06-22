<?php

declare(strict_types=1);

namespace EBoost\Menu\Controller\Adminhtml\Menu;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use EBoost\Menu\Api\MenuRepositoryInterface;
use EBoost\Menu\Api\Data\MenuInterface;
use EBoost\Menu\Controller\Adminhtml\MenuAction;
use EBoost\Menu\Model\MenuFactory;
use EBoost\Menu\Service\Menu\CloneRequestProcessor;
use EBoost\Menu\Service\Menu\Hydrator as MenuHydrator;
use EBoost\Menu\Service\Menu\SaveRequestProcessor as MenuSaveRequestProcessor;

class Save extends MenuAction implements HttpPostActionInterface
{
    private const EDIT_RETURN_REDIRECTS = ['edit', 'continue', 'duplicate'];

    /**
     * @var CloneRequestProcessor
     */
    private $cloneRequestProcessor;

    /**
     * @var MenuHydrator
     */
    private $hydrator;

    /**
     * @var MenuSaveRequestProcessor
     */
    private $menuSaveRequestProcessor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        MenuRepositoryInterface $menuRepository,
        MenuFactory $menuFactory,
        CloneRequestProcessor $cloneRequestProcessor,
        MenuHydrator $hydrator,
        MenuSaveRequestProcessor $menuSaveRequestProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->cloneRequestProcessor = $cloneRequestProcessor;
        $this->hydrator = $hydrator;
        $this->menuSaveRequestProcessor = $menuSaveRequestProcessor;
        $this->storeManager = $storeManager;

        parent::__construct($context, $menuRepository, $menuFactory);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $menu = $this->getCurrentMenu();
        $request = $this->getRequest();
        $nodes = $request->getParam('serialized_nodes');
        $nodes = $nodes ? json_decode($nodes, true) : [];

        $this->hydrator->mapRequest($menu, $request);
        $this->menuRepository->save($menu);
        $menu->saveStores($this->getStores());

        $this->menuSaveRequestProcessor->saveData($menu, $nodes);

        return $this->processRedirect($menu);
    }

    private function processRedirect(MenuInterface $menu): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $redirect = $this->getRequest()->getParam('back');

        $pathAction = '';
        $pathParams = [];

        if ($redirect === 'duplicate') {
            $menu = $this->cloneRequestProcessor->clone($menu);
        }

        if (in_array($redirect, self::EDIT_RETURN_REDIRECTS)) {
            $pathAction = 'edit';
            $pathParams = [self::ID => $menu->getId(), '_current' => true];
        }

        return $resultRedirect->setPath("*/*/{$pathAction}", $pathParams);
    }

    private function getStores(): array
    {
        $request = $this->getRequest();
        $stores = $request->getParam('stores');
        if ($this->storeManager->isSingleStoreMode() || $stores === null) {
            return [$this->storeManager->getStore()->getId()];
        }

        return $stores;
    }
}
