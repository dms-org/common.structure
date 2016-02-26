<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem\Form;

use Dms\Core\File\IUploadedImage;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FileFieldBuilder;
use Dms\Core\Form\Field\Type\ImageType;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Model\Type\IType;

/**
 * The image upload field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageUploadType extends FileUploadType
{
    const ATTR_MIN_WIDTH = ImageType::ATTR_MIN_WIDTH;
    const ATTR_MAX_WIDTH = ImageType::ATTR_MAX_WIDTH;

    const ATTR_MIN_HEIGHT = ImageType::ATTR_MIN_HEIGHT;
    const ATTR_MAX_HEIGHT = ImageType::ATTR_MAX_HEIGHT;

    /**
     * @return IType
     */
    protected function processedType() : IType
    {
        return Type::object(IUploadedImage::class);
    }

    /**
     * @param Field $field
     *
     * @return FileFieldBuilder
     */
    protected function fileField(Field $field) : FileFieldBuilder
    {
        return $field->image()->attrs($this->getAll([
            self::ATTR_MIN_WIDTH,
            self::ATTR_MAX_WIDTH,
            self::ATTR_MIN_HEIGHT,
            self::ATTR_MAX_HEIGHT,
        ]));
    }
}