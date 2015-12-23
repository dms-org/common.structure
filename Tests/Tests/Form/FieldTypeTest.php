<?php

namespace Dms\Common\Structure\Tests\Form;

use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Form\Field\Field;
use Dms\Core\Form\IField;
use Dms\Core\Form\IFieldType;
use Dms\Core\Form\InvalidFormSubmissionException;
use Dms\Core\Form\InvalidInputException;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\IType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class FieldTypeTest extends CmsTestCase
{
    /**
     * @var IFieldType
     */
    protected $type;

    /**
     * @var IField
     */
    protected $field;

    /**
     * @return IFieldType
     */
    abstract protected function buildFieldType();

    public function setUp()
    {
        $this->loadFieldType($this->buildFieldType());
    }

    /**
     * @param IFieldType $fieldType
     */
    protected function loadFieldType(IFieldType $fieldType)
    {
        $this->type  = $fieldType;
        $this->field = new Field('test', 'Test', $this->type, []);
    }


    /**
     * @return IType
     */
    abstract public function processedType();

    /**
     * @return array[]
     */
    abstract public function validationTests();

    /**
     * @return array[]
     */
    abstract public function processTests();

    /**
     * @return array[]
     */
    abstract public function unprocessTests();

    public function testProcessedType()
    {
        $this->assertEquals($this->processedType(), $this->type->getProcessedPhpType());
    }

    /**
     * @dataProvider validationTests
     */
    public function testValidation($input, array $messages, $fieldMessages = true)
    {
        /** @var Message[] $messages */
        if ($fieldMessages) {
            foreach ($messages as $key => $message) {
                if (!isset($message->getParameters()['field'])) {
                    $messages[$key] = $message->withParameters([
                            'field' => 'Test',
                            'input' => $input,
                    ]);
                }
            }
        }

        /** @var InvalidInputException|InvalidFormSubmissionException $e */
        try {
            $this->field->process($input);
            $this->fail('Exception was not thrown');
        } catch (InvalidInputException $e) {
            $this->assertEquals($messages, $e->getMessages());
        } catch (InvalidFormSubmissionException $e) {
            $this->assertEquals($messages, $e->getAllMessages());
        }
    }

    /**
     * @dataProvider processTests
     */
    public function testProcess($input, $processed)
    {
        $this->assertEquals($processed, $this->field->process($input));
    }

    /**
     * @dataProvider unprocessTests
     */
    public function testUnprocess($processed, $unprocessed)
    {
        $this->assertEquals($unprocessed, $this->field->unprocess($processed));
    }
}