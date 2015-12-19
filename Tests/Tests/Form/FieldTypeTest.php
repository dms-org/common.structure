<?php

namespace Iddigital\Cms\Common\Structure\Tests\Form;

use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\BaseException;
use Iddigital\Cms\Core\Form\Field\Field;
use Iddigital\Cms\Core\Form\IField;
use Iddigital\Cms\Core\Form\IFieldType;
use Iddigital\Cms\Core\Form\InvalidFormSubmissionException;
use Iddigital\Cms\Core\Form\InvalidInputException;
use Iddigital\Cms\Core\Language\Message;

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
        $this->type  = $this->buildFieldType();
        $this->field = new Field('test', 'Test', $this->type, []);
    }

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

    /**
     * @dataProvider validationTests
     */
    public function testValidation($input, array $messages)
    {
        /** @var Message[] $messages */
        foreach ($messages as $key => $message) {
            if (!isset($message->getParameters()['field'])) {
                $messages[$key] = $message->withParameters([
                        'field' => 'Test',
                        'input' => $input,
                ]);
            }
        }


        /** @var InvalidInputException|InvalidFormSubmissionException $e */
        $e = $this->assertThrows(function () use ($input) {
            $this->field->process($input);
        }, BaseException::class);

        if ($e instanceof InvalidInputException) {
            $this->assertEquals($messages, $e->getMessages());
        } elseif ($e instanceof InvalidFormSubmissionException) {
            $this->assertEquals($messages, $e->getAllMessages());
        } else {
            $this->fail('Unknown exception type :' . get_class($e));
        }
    }

    /**
     * @dataProvider processTests
     */
    public function testProcess($input, $processed)
    {
        $this->assertEquals(
                $processed,
                $this->field->process($input)
        );
    }

    /**
     * @dataProvider unprocessTests
     */
    public function testUnprocess($processed, $unprocessed)
    {
        $this->assertEquals(
                $unprocessed,
                $this->field->unprocess($processed)
        );
    }
}