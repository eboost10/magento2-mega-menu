<?php

namespace EBoost\Menu\Controller\Adminhtml\Menu;

use EBoost\Menu\Model\ResourceModel\Menu\Collection;

class MassDisable extends MassActionAbstract
{
    protected function process(Collection $collection)
    {
        $this->menuRepository->setIsActiveByIds($collection->getAllIds(), 0);
    }
}
