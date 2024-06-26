<?php

namespace EBoost\Menu\Plugin\Model\ResourceModel\Menu\AroundSave;

use EBoost\Menu\Api\Data\MenuInterface;
use EBoost\Menu\Model\ResourceModel\Menu as MenuResourceModel;
use EBoost\Menu\Plugin\Model\ResourceModel\Menu\Save as MenuSave;

class InvalidatePageCache
{
    /**
     * @var MenuSave
     */
    private $menuSave;

    public function __construct(MenuSave $menuSave)
    {
        $this->menuSave = $menuSave;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    public function aroundSave(MenuResourceModel $subject, callable $proceed, MenuInterface $menu)
    {
        return $this->menuSave->saveAndInvalidatePageCache($menu, $proceed);
    }
}
