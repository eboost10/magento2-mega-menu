<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ImportExport\Processor\Import;

use EBoost\Menu\Api\Data\MenuInterface;
use EBoost\Menu\Api\Data\MenuInterfaceFactory;
use EBoost\Menu\Api\MenuRepositoryInterface;
use EBoost\Menu\Model\ImportExport\Processor\Import\Menu\DataProcessor;
use EBoost\Menu\Model\ImportExport\Processor\Import\Menu\Validator;

class Menu
{
    /**
     * @var MenuInterfaceFactory
     */
    private $menuFactory;

    /**
     * @var MenuRepositoryInterface
     */
    private $menuRepository;

    /**
     * @var DataProcessor
     */
    private $dataProcessor;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(
        MenuInterfaceFactory $menuFactory,
        MenuRepositoryInterface $menuRepository,
        DataProcessor $dataProcessor,
        Validator $validator
    ) {
        $this->menuFactory = $menuFactory;
        $this->menuRepository = $menuRepository;
        $this->dataProcessor = $dataProcessor;
        $this->validator = $validator;
    }

    public function createMenu(array $data, array $stores): MenuInterface
    {
        $menu = $this->menuFactory->create();

        $menu->setData($this->dataProcessor->getMenuData($data));
        $this->menuRepository->save($menu);
        $menu->saveStores($this->dataProcessor->getStoreIds($stores));

        return $menu;
    }

    public function validateImportData(array $data): void
    {
        $this->validator->validate($data);
    }
}
