<?php
/**
 * EBoost
 *
 * @author      Paweł Pisarek <pawel.pisarek@snow.dog>.
 * @category
 * @package
 * @copyright   Copyright EBoost (http://snow.dog)
 */

namespace EBoost\Menu\Model\NodeType;

class CmsPage extends AbstractNode
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(\EBoost\Menu\Model\ResourceModel\NodeType\CmsPage::class);
        parent::_construct();
    }

    /**
     * @inheritDoc
     */
    public function fetchConfigData()
    {
        $this->profiler->start(__METHOD__);

        $options = array_map(function ($page) {
            return [
                'id' => $page->getId(),
                'label' => $page->getTitle(),
                'value' => $page->getIdentifier(),
                'store' => array_filter(
                    (array)$page->getStoreId(),
                    function ($id) {
                        return (int)$id !== 0;
                    }
                )
            ];
        }, $this->getResource()->fetchConfigData());

        $this->profiler->stop(__METHOD__);

        return $options;
    }

    /**
     * @inheritDoc
     */
    public function fetchData(array $nodes, $storeId)
    {
        $this->profiler->start(__METHOD__);

        $localNodes = [];
        $pagesCodes = [];

        foreach ($nodes as $node) {
            $localNodes[$node->getId()] = $node;
            $pagesCodes[] = $node->getContent();
        }

        /** @var \EBoost\Menu\Model\ResourceModel\NodeType\CmsPage $resource */
        $resource = $this->getResource();
        $pageIds = $resource->getPageIds($storeId, $pagesCodes);
        $pageUrls = $resource->fetchData($storeId, $pageIds);

        $this->profiler->stop(__METHOD__);

        return [$localNodes, $pageIds, $pageUrls];
    }
}
