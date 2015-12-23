<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\Form\TimeOfDayType;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDayTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new TimeOfDayType('H:i:s');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return TimeOfDay::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['123', [new Message(DateFormatValidator::MESSAGE, ['input' => '123', 'format' => 'H:i:s'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['14:20:50', new TimeOfDay(14, 20, 50)],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new TimeOfDay(14, 20, 50), '14:20:50'],
        ];
    }
}