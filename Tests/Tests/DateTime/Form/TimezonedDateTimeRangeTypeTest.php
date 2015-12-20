<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeRangeType;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\OneOfValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Form\Processor\Validator\FieldLessThanOrEqualAnotherValidator;
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
        return new TimezonedDateTimeRangeType('Y-m-d H:i:s');
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        $timezoneOptions = implode(', ', \DateTimeZone::listIdentifiers());

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
                                new Message(TypeValidator::MESSAGE, ['field' => 'Start', 'input' => 123, 'type' => 'array<mixed>|null']),
                                new Message(TypeValidator::MESSAGE, ['field' => 'End', 'input' => 355, 'type' => 'array<mixed>|null']),
                        ]
                ],
                [
                        ['start' => ['datetime' => '123', 'timezone' => 'UTC'], 'end' => ['datetime' => '255', 'timezone' => 'UTC']],
                        [
                                new Message(DateFormatValidator::MESSAGE,
                                        ['field' => 'Start > Date/Time', 'input' => 123, 'format' => 'Y-m-d H:i:s']),
                                new Message(DateFormatValidator::MESSAGE,
                                        ['field' => 'End > Date/Time', 'input' => 255, 'format' => 'Y-m-d H:i:s']),
                        ]
                ],
                [
                        [
                                'start' => ['datetime' => '2000-01-01 00:00:00', 'timezone' => 'bad'],
                                'end'   => ['datetime' => '2000-01-01 00:00:00', 'timezone' => 'bad']
                        ],
                        [
                                new Message(OneOfValidator::MESSAGE,
                                        ['field' => 'Start > Timezone', 'input' => 'bad', 'options' => $timezoneOptions]),
                                new Message(OneOfValidator::MESSAGE,
                                        ['field' => 'End > Timezone', 'input' => 'bad', 'options' => $timezoneOptions]),
                        ]
                ],
                [
                        [
                                'start' => ['datetime' => '2010-01-01 00:00:00', 'timezone' => 'UTC'],
                                'end'   => ['datetime' => '2000-01-01 00:00:00', 'timezone' => 'UTC']
                        ],
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
                        [
                                'start' => ['datetime' => '2000-01-01 10:00:00', 'timezone' => 'Australia/Melbourne'],
                                'end'   => ['datetime' => '2012-01-01 12:30:00', 'timezone' => 'UTC'],
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
                                'start' => ['datetime' => '2000-01-01 10:00:00', 'timezone' => 'Australia/Melbourne'],
                                'end'   => ['datetime' => '2012-01-01 12:30:00', 'timezone' => 'UTC'],
                        ],
                ],
        ];
    }
}