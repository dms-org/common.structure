<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\Form\DateTimeType;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new DateTimeType('Y-m-d H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return DateTime::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['123', [new Message(DateFormatValidator::MESSAGE, ['input' => '123', 'format' => 'Y-m-d H:i:s'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['2000-01-01 10:00:00', DateTime::fromString('2000-01-01 10:00:00')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [DateTime::fromString('2000-01-01 10:00:00'), '2000-01-01 10:00:00'],
        ];
    }
}