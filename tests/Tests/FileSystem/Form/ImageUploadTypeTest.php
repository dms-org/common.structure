<?php

namespace Dms\Common\Structure\Tests\FileSystem\Form;

use Dms\Common\Structure\FileSystem\Form\FileUploadType;
use Dms\Common\Structure\FileSystem\Form\ImageUploadType;
use Dms\Common\Structure\FileSystem\UploadAction;
use Dms\Common\Structure\FileSystem\UploadedImage;
use Dms\Core\File\IUploadedImage;
use Dms\Core\Form\Field\Processor\Validator\ImageDimensionsValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\Field\Processor\Validator\UploadedImageValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ImageUploadTypeTest extends FileUploadTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return (new ImageUploadType())->with(FileUploadType::ATTR_INITIAL_VALUE, $this->mockUploadedFile('existing'));
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Type::object(IUploadedImage::class)->nullable();
    }

    /**
     * @return mixed
     */
    protected function uploadClass()
    {
        return IUploadedImage::class;
    }

    protected function mockUploadedFile($name, $fileSize = 10, $isValidImage = true, $height = 10, $width = 10)
    {
        $mock = $this->getMock(
                UploadedImage::class,
                ['getSize', 'isValidImage', 'getHeight', 'getWidth'],
                ['somepath/' . $name, UPLOAD_ERR_OK]
        );

        $mock->method('getSize')->willReturn($fileSize);
        $mock->method('getHeight')->willReturn($height);
        $mock->method('getWidth')->willReturn($width);
        $mock->method('isValidImage')->willReturn($isValidImage);

        return $mock;
    }

    public function testInvalidImage()
    {
        $this->testValidation(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = $this->mockUploadedFile('new', 1024, false)],
                [new Message(UploadedImageValidator::MESSAGE, ['field' => 'File', 'input' => $file])]
        );

        $this->testValidation(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = parent::mockUploadedFile('new', 1024)],
                [new Message(TypeValidator::MESSAGE, ['field' => 'File', 'input' => $file, 'type' => IUploadedImage::class . '|null'])]
        );
    }

    public function testMaxHeight()
    {
        $this->loadFieldType((new ImageUploadType())->with(ImageUploadType::ATTR_MAX_HEIGHT, 100));

        $this->testProcess(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = $this->mockUploadedFile('new', 1024, true, 100)],
                $file
        );

        $this->testValidation(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = $this->mockUploadedFile('new', 1024, true, 101)],
                [new Message(ImageDimensionsValidator::MESSAGE_MAX_HEIGHT, ['field' => 'File', 'input' => $file, 'max_height' => 100])]
        );
    }
}