<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ImportExport\Processor\Export\Node;

use EBoost\Menu\Api\Data\NodeInterface;
use EBoost\Menu\Model\ImportExport\Processor\Export\Node\TypeContent;

class DataProcessor
{
    /**
     * @var TypeContent
     */
    private $typeContent;

    public function __construct(TypeContent $typeContent)
    {
        $this->typeContent = $typeContent;
    }

    public function getData(array $data): array
    {
        $data[NodeInterface::CONTENT] = $this->typeContent->get(
            $data[NodeInterface::TYPE],
            $data[NodeInterface::CONTENT]
        );

        return $data;
    }
}
