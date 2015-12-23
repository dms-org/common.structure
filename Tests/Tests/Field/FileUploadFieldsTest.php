<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\FileSystem\Form\FileUploadType;
use Dms\Common\Structure\FileSystem\Form\ImageUploadType;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileUploadFieldsTest extends CmsTestCase
{
    public function testFileUpload()
    {
        $type = Field::forType()->file()
                ->extensions(['gif', 'bmp'])
                ->minSize(100)
                ->maxSize(1024)
                ->build()
                ->getType();

        $this->assertInstanceOf(FileUploadType::class, $type);
        $this->assertArraySubset([
                FileUploadType::ATTR_EXTENSIONS => ['gif', 'bmp'],
                FileUploadType::ATTR_MIN_SIZE   => 100,
                FileUploadType::ATTR_MAX_SIZE   => 1024,
        ], $type->attrs());
    }

    public function testImageUpload()
    {
        $type = Field::forType()->image()
                ->minWidth(10)
                ->maxWidth(100)
                ->minHeight(20)
                ->maxHeight(200)
                ->build()
                ->getType();

        $this->assertInstanceOf(ImageUploadType::class, $type);
        $this->assertArraySubset([
                ImageUploadType::ATTR_MIN_WIDTH  => 10,
                ImageUploadType::ATTR_MAX_WIDTH  => 100,
                ImageUploadType::ATTR_MIN_HEIGHT => 20,
                ImageUploadType::ATTR_MAX_HEIGHT => 200,
        ], $type->attrs());
    }
}