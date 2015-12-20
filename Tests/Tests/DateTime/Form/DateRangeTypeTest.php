<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateRange;
use Dms\Common\Structure\DateTime\Form\DateRangeType;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\IFieldType;
use Dms\Core\Form\Processor\Validator\FieldLessThanOrEqualAnotherValidator;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeTypeTest extends FieldTypeTest
{
    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new DateRangeType('Y-m-d');
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
                        ['start_date' => '123', 'end_date' => '355'],
                        [
                                new Message(DateFormatValidator::MESSAGE, ['field' => 'Start', 'input' => 123, 'format' => 'Y-m-d']),
                                new Message(DateFormatValidator::MESSAGE, ['field' => 'End', 'input' => 355, 'format' => 'Y-m-d']),
                        ]
                ],
                [
                        ['start_date' => '2010-01-01', 'end_date' => '2000-01-01'],
                        [
                                new Message(FieldLessThanOrEqualAnotherValidator::MESSAGE, ['field1' => 'Start', 'field2' => 'End']),
                        ], false
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [['start_date' => '2000-01-01', 'end_date' => '2000-05-22'], new DateRange(new Date(2000, 1, 1), new Date(2000, 5, 22))],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        return [
                [new DateRange(new Date(2000, 1, 1), new Date(2000, 5, 22)), ['start_date' => '2000-01-01', 'end_date' => '2000-05-22']],
        ];
    }
}