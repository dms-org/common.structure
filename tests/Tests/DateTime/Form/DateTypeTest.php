<?php

namespace Dms\Common\Structure\Tests\DateTimeTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\Form\DateType;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new DateType('Y-m-d');
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return Date::type();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['123', [new Message(DateFormatValidator::MESSAGE, ['input' => '123', 'format' => 'Y-m-d'])]],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                ['2000-01-01', new Date(2000, 1, 1)],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new Date(2000, 1, 1), '2000-01-01'],
        ];
    }
}