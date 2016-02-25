<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem\Form\Builder;

use Dms\Common\Structure\FileSystem\Image;
use Dms\Core\Form\Field\Builder\ImageFieldBuilder;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageUploadFieldBuilder extends ImageFieldBuilder
{
    protected function movedClassName() : string
    {
        return Image::class;
    }
}