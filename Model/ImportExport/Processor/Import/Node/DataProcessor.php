<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ImportExport\Processor\Import\Node;

use EBoost\Menu\Api\Data\NodeInterface;
use EBoost\Menu\Model\ImportExport\Processor\ExtendedFields;
use EBoost\Menu\Model\ImportExport\Processor\Import\FieldProcessor\Boolean as BooleanField;
use EBoost\Menu\Model\ImportExport\Processor\Import\Node\TypeContent;

class DataProcessor
{
    /**
     * @var BooleanField
     */
    private $booleanField;

    /**
     * @var TypeContent
     */
    private $typeContent;

    public function __construct(BooleanField $booleanField, TypeContent $typeContent)
    {
        $this->booleanField = $booleanField;
        $this->typeContent = $typeContent;
    }

    public function getData(
        array $data,
        int $menuId,
        int $level = 0,
        int $position = 0,
        ?int $parentId = null
    ): array {
        $data[NodeInterface::MENU_ID] = $menuId;
        $data[NodeInterface::PARENT_ID] = $parentId;
        $data[NodeInterface::LEVEL] = $level;
        $data[NodeInterface::POSITION] = $position;

        if (isset($data[NodeInterface::CONTENT]) && $data[NodeInterface::CONTENT] !== '') {
            $data[NodeInterface::CONTENT] = $this->typeContent->get(
                (string) $data[NodeInterface::TYPE],
                $data[NodeInterface::CONTENT]
            );
        }

        if (isset($data[NodeInterface::TARGET])) {
            $data[NodeInterface::TARGET] = $this->booleanField->getValue($data[NodeInterface::TARGET]);
        }

        if (isset($data[NodeInterface::IS_ACTIVE])) {
            $data[NodeInterface::IS_ACTIVE] = $this->booleanField->getValue($data[NodeInterface::IS_ACTIVE]);
        }

        unset($data[ExtendedFields::NODES]);

        return $data;
    }
}
