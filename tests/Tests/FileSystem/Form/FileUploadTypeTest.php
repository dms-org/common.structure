<?php

namespace Dms\Common\Structure\Tests\FileSystem\Form;

use Dms\Common\Structure\FileSystem\Form\FileUploadType;
use Dms\Common\Structure\FileSystem\UploadAction;
use Dms\Common\Structure\FileSystem\UploadedFile;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\File\IUploadedFile;
use Dms\Core\Form\Field\Processor\Validator\FileSizeValidator;
use Dms\Core\Form\Field\Processor\Validator\OneOfValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileUploadTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return (new FileUploadType())->with(FileUploadType::ATTR_INITIAL_VALUE, $this->mockUploadedFile('existing'));
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Type::object(IUploadedFile::class);
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['agds', [new Message(TypeValidator::MESSAGE, ['type' => 'array<mixed>|null'])]],
                [
                        [],
                        [new Message(RequiredValidator::MESSAGE, ['field' => 'Action', 'input' => null]),]
                ],
                [
                        ['file' => '123', 'action' => []],
                        [
                                new Message(TypeValidator::MESSAGE,
                                        ['field' => 'File', 'input' => '123', 'type' => $this->uploadClass() . '|null']),
                                new Message(TypeValidator::MESSAGE, ['field' => 'Action', 'input' => [], 'type' => 'string']),
                        ],
                ],
                [
                        ['action' => UploadAction::STORE_NEW],
                        [new Message(RequiredValidator::MESSAGE),],
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [
                        ['file' => $this->mockUploadedFile('file'), 'action' => UploadAction::STORE_NEW],
                        $this->mockUploadedFile('file'),
                ],
                [
                        ['file' => null, 'action' => UploadAction::KEEP_EXISTING],
                        $this->mockUploadedFile('existing'),
                ],
                [
                        ['file' => null, 'action' => UploadAction::DELETE_EXISTING],
                        null,
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [$this->mockUploadedFile('file'), ['file' => $this->mockUploadedFile('file'), 'action' => UploadAction::STORE_NEW]],
                [null, null],
        ];
    }

    protected function mockUploadedFile($name, $fileSize = 10)
    {
        $mock = $this->getMock(UploadedFile::class, ['getSize'], ['somepath/' . $name, UPLOAD_ERR_OK]);

        $mock->method('getSize')->willReturn($fileSize);

        return $mock;
    }

    /**
     * @return mixed
     */
    protected function uploadClass()
    {
        return IUploadedFile::class;
    }

    public function testWithoutExistingFile()
    {
        $this->loadFieldType(new FileUploadType());

        $this->testProcess(['action' => UploadAction::KEEP_EXISTING], null);
    }

    public function testRequiredWithoutExistingFile()
    {
        $this->loadFieldType((new FileUploadType())->with(FileUploadType::ATTR_REQUIRED, true));

        $this->testValidation(
                ['action' => UploadAction::KEEP_EXISTING],
                [
                        new Message(OneOfValidator::MESSAGE,
                                ['field' => 'Action', 'input' => UploadAction::KEEP_EXISTING, 'options' => 'store-new'])
                ]
        );

        $this->testValidation(
                ['action' => UploadAction::DELETE_EXISTING],
                [
                        new Message(OneOfValidator::MESSAGE,
                                ['field' => 'Action', 'input' => UploadAction::DELETE_EXISTING, 'options' => 'store-new'])
                ]
        );
    }

    public function testRequiredWithExistingFile()
    {
        $this->loadFieldType((new FileUploadType())->withAll([
                FileUploadType::ATTR_REQUIRED      => true,
                FileUploadType::ATTR_INITIAL_VALUE => $this->mockUploadedFile('existing')
        ]));

        $this->testProcess(
                ['action' => UploadAction::KEEP_EXISTING],
                $this->mockUploadedFile('existing')
        );

        $this->testValidation(
                ['action' => UploadAction::DELETE_EXISTING],
                [
                        new Message(OneOfValidator::MESSAGE,
                                ['field' => 'Action', 'input' => UploadAction::DELETE_EXISTING, 'options' => 'store-new, keep-existing'])
                ]
        );
    }

    public function testMaxSize()
    {
        $this->loadFieldType((new FileUploadType())->withAll([
                FileUploadType::ATTR_MAX_SIZE => 1024,
        ]));

        $this->testProcess(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = $this->mockUploadedFile('new', 1024)],
                $file
        );

        $this->testValidation(
                ['action' => UploadAction::STORE_NEW, 'file' => $file = $this->mockUploadedFile('new', 1025)],
                [new Message(FileSizeValidator::MESSAGE_MAX, ['field' => 'File', 'input' => $file, 'max_size' => 1024])]
        );
    }
}