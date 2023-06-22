<?php
/**
 * EBoost
 *
 * @author      Paweł Pisarek <pawel.pisarek@snow.dog>.
 * @category
 * @package
 * @copyright   Copyright EBoost (http://snow.dog)
 */

namespace EBoost\Menu\Api\Data;

interface NodeTypeInterface
{
    /**
     * Fetch additional data required for rendering nodes.
     *
     * @param array $nodes
     * @param int|string $storeId
     *
     * @return mixed
     */
    public function fetchData(array $nodes, $storeId);

    /**
     * Fetch additional data required for config.
     *
     * @return mixed
     */
    public function fetchConfigData();

    /**
     * Handles nodes complex clone operations by their types.
     */
    public function processNodeClone(NodeInterface $node, NodeInterface $nodeClone): void;
}
