<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeType;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\OneOfValidator;
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
        return new TimezonedDateTimeType('Y-m-d H:i:s');
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        $timezoneOptions = implode(', ', \DateTimeZone::listIdentifiers());

        return [
                [
                        ['datetime' => '123', 'timezone' => 'UTC'],
                        [new Message(DateFormatValidator::MESSAGE, ['field' => 'Date/Time', 'input' => 123, 'format' => 'Y-m-d H:i:s'])]
                ],
                [
                        ['datetime' => '2000-01-01 00:00:00', 'timezone' => 'bad'],
                        [new Message(OneOfValidator::MESSAGE, ['field' => 'Timezone', 'input' => 'bad', 'options' => $timezoneOptions])]
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
                        ['datetime' => '2000-01-01 10:00:00', 'timezone' => 'Australia/Melbourne'],
                        TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne'),
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
                        TimezonedDateTime::fromString('2000-01-01 10:00:00', 'Australia/Melbourne'),
                        ['datetime' => '2000-01-01 10:00:00', 'timezone' => 'Australia/Melbourne'],
                ],
        ];
    }
}