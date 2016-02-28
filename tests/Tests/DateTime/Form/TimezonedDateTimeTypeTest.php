<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeType;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new TimezonedDateTimeType('Y-m-d H:i:s e');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return TimezonedDateTime::type()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                [
                        'datetime' => '123',
                        [new Message(DateFormatValidator::MESSAGE, ['format' => 'Y-m-d H:i:s e'])]
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['2000-01-01 10:00:00 Australia/Melbourne', TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne')],
                ['2010-08-09 10:33:55 UTC', TimezonedDateTime::fromString('2010-08-09 10:33:55', 'UTC')],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne'), '2000-01-01 10:00:00 Australia/Melbourne'],
                [TimezonedDateTime::fromString('2010-08-09 10:33:55', 'UTC'), '2010-08-09 10:33:55 UTC'],
        ];
    }
}