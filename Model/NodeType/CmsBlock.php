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

class CmsBlock extends AbstractNode
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(\EBoost\Menu\Model\ResourceModel\NodeType\CmsBlock::class);
        parent::_construct();
    }

    /**
     * @inheritDoc
     */
    public function fetchConfigData()
    {
        $this->profiler->start(__METHOD__);

        $options = array_map(function ($block) {
            return [
                'id' => $block->getId(),
                'label' => $block->getTitle(),
                'value' => $block->getIdentifier(),
                'store' => array_filter(
                    (array)$block->getStoreId(),
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
        $blocksCodes = [];

        foreach ($nodes as $node) {
            $localNodes[$node->getId()] = $node;
            $blocksCodes[] = $node->getContent();
        }

        $codes = $this->getResource()->fetchData($storeId, $blocksCodes);

        $content = [];

        foreach ($codes as $row) {
            $content[$row['identifier']] = $row['content'];
        }

        $this->profiler->stop(__METHOD__);

        return [$localNodes, $content];
    }
}
