<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem\Form\Builder;

use Dms\Common\Structure\FileSystem\File;
use Dms\Core\Form\Field\Builder\FileFieldBuilder;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileUploadFieldBuilder extends FileFieldBuilder
{
    protected function movedClassName() : string
    {
        return File::class;
    }
}