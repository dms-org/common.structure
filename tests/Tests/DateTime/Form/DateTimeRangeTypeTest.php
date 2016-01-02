<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Common\Structure\DateTime\Form\DateTimeRangeType;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Form\Processor\Validator\FieldLessThanOrEqualAnotherValidator;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new DateTimeRangeType('Y-m-d H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return DateTimeRange::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                [
                        [],
                        [
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Start', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'End', 'input' => null])
                        ]
                ],
                [
                        ['start' => '123', 'end' => '355'],
                        [
                                new Message(DateFormatValidator::MESSAGE, ['field' => 'Start', 'input' => 123, 'format' => 'Y-m-d H:i:s']),
                                new Message(DateFormatValidator::MESSAGE, ['field' => 'End', 'input' => 355, 'format' => 'Y-m-d H:i:s']),
                        ]
                ],
                [
                        ['start' => '2010-01-01 10:00:00', 'end' => '2000-01-01 12:30:00'],
                        [
                                new Message(FieldLessThanOrEqualAnotherValidator::MESSAGE, ['field1' => 'Start', 'field2' => 'End']),
                        ],
                        false
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
                        ['start' => '2000-01-01 10:00:00', 'end' => '2012-01-01 12:30:00'],
                        new DateTimeRange(DateTime::fromString('2000-01-01 10:00:00'), DateTime::fromString('2012-01-01 12:30:00')),
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [
                        new DateTimeRange(DateTime::fromString('2000-01-01 10:00:00'), DateTime::fromString('2012-01-01 12:30:00')),
                        ['start' => '2000-01-01 10:00:00', 'end' => '2012-01-01 12:30:00'],
                ],
        ];
    }
}