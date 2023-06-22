<?php

declare(strict_types=1);

namespace EBoost\Menu\Model\ImportExport\File;

use EBoost\Menu\Model\ImportExport\File\Upload\Content;
use EBoost\Menu\Model\ImportExport\File\Upload\Source;

class Upload
{
    /**
     * @var Content
     */
    private $content;

    /**
     * @var Source
     */
    private $source;

    public function __construct(Content $content, Source $source)
    {
        $this->content = $content;
        $this->source = $source;
    }

    public function uploadFileAndGetData(): array
    {
        return $this->content->flush($this->source->upload());
    }
}
