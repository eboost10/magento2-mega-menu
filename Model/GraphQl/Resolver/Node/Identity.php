<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\GraphQl\Resolver\Node;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;
use EBoost\Menu\Model\GraphQl\Resolver\Identity as EntityIdentity;
use EBoost\Menu\Model\Menu\Node;

class Identity implements IdentityInterface
{
    /**
     * @var EntityIdentity
     */
    private $identity;

    public function __construct(EntityIdentity $identity)
    {
        $this->identity = $identity;
    }

    /**
     * @inheritDoc
     */
    public function getIdentities(array $resolvedData): array
    {
        return $this->identity->getIdentities($resolvedData, Node::NODE_ID, Node::CACHE_TAG);
    }
}
