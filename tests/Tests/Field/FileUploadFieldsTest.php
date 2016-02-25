<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\Form\FileUploadType;
use Dms\Common\Structure\FileSystem\Form\ImageUploadType;
use Dms\Common\Structure\FileSystem\Image;
use Dms\Common\Structure\FileSystem\UploadedFile;
use Dms\Common\Structure\FileSystem\UploadedImage;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\File\IUploadedFile;
use Dms\Core\File\IUploadedImage;
use Dms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileUploadFieldsTest extends CmsTestCase
{
    public function testFileUpload()
    {
        $field = Field::forType()->file()
            ->extensions(['gif', 'bmp'])
            ->minSize(100)
            ->maxSize(1024)
            ->build();
        $type  = $field->getType();

        $this->assertInstanceOf(FileUploadType::class, $type);
        $this->assertArraySubset([
            FileUploadType::ATTR_EXTENSIONS => ['gif', 'bmp'],
            FileUploadType::ATTR_MIN_SIZE   => 100,
            FileUploadType::ATTR_MAX_SIZE   => 1024,
        ], $type->attrs());

        $this->assertEquals(Type::object(IUploadedFile::class), $field->getProcessedType());
    }

    public function testImageUpload()
    {
        $field = Field::forType()->image()
            ->minWidth(10)
            ->maxWidth(100)
            ->minHeight(20)
            ->maxHeight(200)
            ->build();
        $type  = $field->getType();

        $this->assertInstanceOf(ImageUploadType::class, $type);
        $this->assertArraySubset([
            ImageUploadType::ATTR_MIN_WIDTH  => 10,
            ImageUploadType::ATTR_MAX_WIDTH  => 100,
            ImageUploadType::ATTR_MIN_HEIGHT => 20,
            ImageUploadType::ATTR_MAX_HEIGHT => 200,
        ], $type->attrs());

        $this->assertEquals(Type::object(IUploadedImage::class), $field->getProcessedType());
    }

    public function testFileUploadWithMove()
    {
        $field = Field::forType()->file()
            ->required()
            ->moveToPathWithRandomFileName(__DIR__)
            ->build();

        $this->assertEquals(File::type(), $field->getProcessedType());
    }

    public function testImageUploadWithMove()
    {
        $field = Field::forType()->image()
            ->required()
            ->moveToPathWithRandomFileName(__DIR__)
            ->build();

        $this->assertEquals(Image::type(), $field->getProcessedType());
    }
}