<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\NodeType;

use EBoost\Menu\Model\NodeType\AbstractNode;

class CategoryChild extends AbstractNode
{
    /**
     * @inheritDoc
     */
    public function fetchData(array $nodes, $storeId)
    {
        return [];
    }
}
