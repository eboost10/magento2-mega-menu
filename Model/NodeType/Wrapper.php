<?php
/**
 * EBoost
 *
 * @category
 * @package
 * @copyright   Copyright EBoost (http://snow.dog)
 */

namespace EBoost\Menu\Model\NodeType;

use Magento\Framework\Profiler;
use EBoost\Menu\Model\Menu\Node\Image\File as NodeImage;
use EBoost\Menu\Model\TemplateResolver;

class Wrapper extends AbstractNode
{
    /**
     * @var TemplateResolver
     */
    private $templateResolver;

    public function __construct(
        Profiler $profiler,
        NodeImage $nodeImage,
        TemplateResolver $templateResolver
    ) {
        $this->templateResolver = $templateResolver;
        parent::__construct($profiler, $nodeImage);
    }

    /**
     * @inheritDoc
     */
    public function fetchConfigData()
    {
        $this->profiler->start(__METHOD__);

        $data = [
            'snowMenuNodeCustomTemplates' => [
                'defaultTemplate' => 'wrapper',
                'options' => $this->templateResolver->getCustomTemplateOptions('wrapper'),
                'message' => __('Template not found'),
            ],
            'snowMenuSubmenuCustomTemplates' => [
                'defaultTemplate' => 'sub_menu',
                'options' => $this->templateResolver->getCustomTemplateOptions('sub_menu'),
                'message' => __('Template not found'),
            ],
        ];

        $this->profiler->stop(__METHOD__);

        return $data;
    }
}
