<?php
namespace EBoost\Menu\Model\ResourceModel\Menu\Node;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \EBoost\Menu\Model\Menu\Node::class,
            \EBoost\Menu\Model\ResourceModel\Menu\Node::class
        );
    }
}
