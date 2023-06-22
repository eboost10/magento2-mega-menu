<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ResourceModel\Menu;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Node extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('eboostmenu_node', 'node_id');
    }

    public function getFields(): array
    {
        return $this->getConnection()->describeTable($this->getMainTable());
    }
}
