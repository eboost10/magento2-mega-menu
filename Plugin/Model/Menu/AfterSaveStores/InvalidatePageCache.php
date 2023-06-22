<?php

namespace EBoost\Menu\Plugin\Model\Menu\AfterSaveStores;

use EBoost\Menu\Model\Menu;
use EBoost\Menu\Model\Menu\Cache as MenuCache;

class InvalidatePageCache
{
    /**
     * @var MenuCache
     */
    private $menuCache;

    public function __construct(MenuCache $menuCache)
    {
        $this->menuCache = $menuCache;
    }

    /**
     * @param bool $result
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return bool
     */
    public function afterSaveStores(Menu $subject, $result)
    {
        if ($result) {
            $this->menuCache->invalidatePageCache();
        }

        return $result;
    }
}
