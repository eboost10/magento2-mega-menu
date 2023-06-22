<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\Menu\Node;

use EBoost\Menu\Model\Menu\Node\Validator\Product as ProductValidator;

class Validator
{
    /**
     * @var ProductValidator
     */
    private $product;

    public function __construct(ProductValidator $product)
    {
        $this->product = $product;
    }

    public function validate(array $node): void
    {
        switch ($node['type']) {
            case 'product':
                $this->product->validate($node);
                break;
        }
    }
}
