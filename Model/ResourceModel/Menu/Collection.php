<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ResourceModel\Menu;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use EBoost\Menu\Api\Data\MenuInterface;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'menu_id';

    protected function _construct()
    {
        $this->_init(
            \EBoost\Menu\Model\Menu::class,
            \EBoost\Menu\Model\ResourceModel\Menu::class
        );
    }

    public function addStoresData()
    {
        foreach ($this->getItems() as $menu) {
            $menu->addData(['stores' => $menu->getStores()]);
        }

        return $this;
    }

    public function joinStoreRelationTable(): self
    {
        $this->getSelect()
            ->join(
                ['store_table' => $this->getTable(MenuInterface::STORE_RELATION_TABLE)],
                'main_table.' . MenuInterface::MENU_ID . ' = store_table.' . MenuInterface::MENU_ID,
                []
            )
            ->group('main_table.' . MenuInterface::MENU_ID);

        return $this;
    }
}
