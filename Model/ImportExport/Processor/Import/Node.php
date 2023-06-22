<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ImportExport\Processor\Import;

use EBoost\Menu\Api\Data\NodeInterfaceFactory;
use EBoost\Menu\Api\NodeRepositoryInterface;
use EBoost\Menu\Model\ImportExport\Processor\Import\Node\DataProcessor;
use EBoost\Menu\Model\ImportExport\Processor\Import\Node\Validator;
use EBoost\Menu\Model\ImportExport\Processor\Import\Node\Validator\TreeTrace;
use EBoost\Menu\Model\ImportExport\Processor\ExtendedFields;
use EBoost\Menu\Model\ImportExport\File\Yaml;

class Node
{
    /**
     * @var NodeInterfaceFactory
     */
    private $nodeFactory;

    /**
     * @var NodeRepositoryInterface
     */
    private $nodeRepository;

    /**
     * @var DataProcessor
     */
    private $dataProcessor;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var TreeTrace
     */
    private $treeTrace;

    /**
     * @var Yaml
     */
    private $yaml;

    public function __construct(
        NodeInterfaceFactory $nodeFactory,
        NodeRepositoryInterface $nodeRepository,
        DataProcessor $dataProcessor,
        Validator $validator,
        TreeTrace $treeTrace,
        Yaml $yaml
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->nodeRepository = $nodeRepository;
        $this->dataProcessor = $dataProcessor;
        $this->validator = $validator;
        $this->treeTrace = $treeTrace;
        $this->yaml = $yaml;
    }

    public function createNodes(
        array $nodes,
        int $menuId,
        int $level = 0,
        int $position = 0,
        ?int $parentId = null
    ): void {
        foreach ($nodes as $nodeData) {
            $node = $this->nodeFactory->create();
            $data = $this->dataProcessor->getData($nodeData, $menuId, $level, $position++, $parentId);

            $node->setData($data);
            $this->nodeRepository->save($node);

            if (isset($nodeData[ExtendedFields::NODES])) {
                $nodeId = $node->getId() ? (int) $node->getId() : null;
                $this->createNodes($nodeData[ExtendedFields::NODES], $menuId, ($level + 1), 0, $nodeId);
            }
        }
    }

    public function validateImportData(array $data): void
    {
        if ($this->yaml->isHashArray($data)) {
            $this->treeTrace->disableNodeIdAddend();
        }

        $this->validator->validate($data);
    }
}
