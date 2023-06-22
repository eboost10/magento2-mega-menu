<?php

namespace EBoost\Menu\Controller\Adminhtml\Menu;

use EBoost\Menu\Model\ResourceModel\Menu\Collection;

class MassEnable extends MassActionAbstract
{
    protected function process(Collection $collection)
    {
        $this->menuRepository->setIsActiveByIds($collection->getAllIds(), 1);
    }
}
