<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeRangeType;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new TimezonedDateTimeRangeType('Y-m-d H:i:s e');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return TimezonedDateTimeRange::type()->nullable();
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
                                new Message(DateFormatValidator::MESSAGE,
                                        ['field' => 'Start', 'input' => '123', 'format' => 'Y-m-d H:i:s e']),
                                new Message(DateFormatValidator::MESSAGE,
                                        ['field' => 'End', 'input' => '355', 'format' => 'Y-m-d H:i:s e']),
                        ]
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
                        [
                                'start' => '2000-01-01 10:00:00 Australia/Melbourne',
                                'end'   => '2012-01-01 12:30:00 UTC',
                        ],
                        new TimezonedDateTimeRange(
                                TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne'),
                                TimezonedDateTime::fromString('2012-01-01 12:30:00', 'UTC')
                        ),
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
                        new TimezonedDateTimeRange(
                                TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne'),
                                TimezonedDateTime::fromString('2012-01-01 12:30:00', 'UTC')
                        ),
                        [
                                'start' => '2000-01-01 10:00:00 Australia/Melbourne',
                                'end'   => '2012-01-01 12:30:00 UTC',
                        ],
                ],
        ];
    }
}