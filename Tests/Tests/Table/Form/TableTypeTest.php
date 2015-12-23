<?php

namespace Dms\Common\Structure\Tests\Table\Form;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Field;
use Dms\Common\Structure\Table\Form\TableType;
use Dms\Common\Structure\Tests\Form\FieldTypeTest;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Dms\Core\Form\Field\Processor\Validator\DateFormatValidator;
use Dms\Core\Form\Field\Processor\Validator\MaxArrayLengthValidator;
use Dms\Core\Form\Field\Processor\Validator\MinArrayLengthValidator;
use Dms\Core\Form\Field\Processor\Validator\OneOfValidator;
use Dms\Core\Form\Field\Processor\Validator\RequiredValidator;
use Dms\Core\Form\Field\Processor\Validator\TypeValidator;
use Dms\Core\Form\Field\Type\ArrayOfType;
use Dms\Core\Form\IFieldType;
use Dms\Core\Language\Message;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableTypeTest extends FieldTypeTest
{
    /**
     * @var TableType
     */
    protected $type;

    /**
     * @return IFieldType
     */
    protected function buildFieldType()
    {
        return new TableType(
                TestBusinessHoursTimetableCell::class,
                Field::forType()->enum(DayOfWeek::class, DayOfWeek::getShortNameMap())->required()->build(),
                Field::forType()->time('G:i')->required()->build(),
                Field::forType()->enum(TestBusinessAvailability::class, [
                        TestBusinessAvailability::OPEN   => 'Open',
                        TestBusinessAvailability::CLOSED => 'Closed',
                ])->build()
        );
    }

    /**
     * @inheritDoc
     */
    public function processedType()
    {
        return TestBusinessHoursTimetableCell::collectionType()->nullable();
    }

    /**
     * @return array[]
     */
    public function validationTests()
    {
        return [
                ['abc', [new Message(TypeValidator::MESSAGE, ['type' => 'array<mixed>|null'])]],
                [
                        [],
                        [
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Columns', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Rows', 'input' => null]),
                                new Message(RequiredValidator::MESSAGE, ['field' => 'Cells', 'input' => null]),
                        ]
                ],
                [
                        [
                                'columns' => 'abc',
                                'rows'    => 'abc',
                                'cells'   => 'abc',
                        ],
                        [
                                new Message(TypeValidator::MESSAGE,
                                        ['field' => 'Columns', 'input' => 'abc', 'type' => 'array<mixed>|null']),
                                new Message(TypeValidator::MESSAGE,
                                        ['field' => 'Rows', 'input' => 'abc', 'type' => 'array<string|null>|null']),
                                new Message(TypeValidator::MESSAGE,
                                        ['field' => 'Cells', 'input' => 'abc', 'type' => 'array<array<mixed>|null>|null']),
                        ]
                ],
                [
                        [
                                'columns' => [],
                                'rows'    => [],
                                'cells'   => ['abc'],
                        ],
                        [
                                new Message(TypeValidator::MESSAGE,
                                        ['field' => 'Cells', 'input' => ['abc'], 'type' => 'array<array<mixed>|null>|null']),
                        ]
                ],
                [
                        [
                                'columns' => ['123'],
                                'rows'    => ['abc'],
                                'cells'   => [],
                        ],
                        [
                                new Message(OneOfValidator::MESSAGE,
                                        ['field' => 'Columns', 'input' => ['123'], 'options' => implode(', ', range(1, 7)), 'key' => 0]),
                                new Message(DateFormatValidator::MESSAGE,
                                        ['field' => 'Rows', 'input' => ['abc'], 'format' => 'G:i', 'key' => 0]),
                        ]
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        $open   = TestBusinessAvailability::open();
        $closed = TestBusinessAvailability::closed();

        return [
                [
                        [
                                'columns' => ['1', '2'],
                                'rows'    => ['9:00', '10:00'],
                                'cells'   => [
                                        ['open', 'open'],
                                        ['open', 'closed'],
                                ],
                        ],
                        TestBusinessHoursTimetableCell::collection([
                                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(9), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(10), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(9), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(10), $closed),
                        ])
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        $open   = TestBusinessAvailability::open();
        $closed = TestBusinessAvailability::closed();

        return [
                [
                        TestBusinessHoursTimetableCell::collection([
                                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(9), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(10), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(9), $open),
                                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(10), $closed),
                        ]),
                        [
                                'columns' => [1, 2],
                                'rows'    => ['9:00', '10:00'],
                                'cells'   => [
                                        ['open', 'open'],
                                        ['open', 'closed'],
                                ],
                        ],
                ],
        ];
    }

    public function testColumnAmountValidation()
    {
        $open   = TestBusinessAvailability::open();
        $closed = TestBusinessAvailability::closed();

        $this->loadFieldType(
                $this->buildFieldType()
                        ->with(TableType::ATTR_MIN_COLUMNS, 2)
                        ->with(TableType::ATTR_MAX_COLUMNS, 3)
        );

        $this->assertSame(2, $this->type->getForm()->getField(TableType::COLUMNS_FIELD)->getType()->get(ArrayOfType::ATTR_MIN_ELEMENTS));
        $this->assertSame(3, $this->type->getForm()->getField(TableType::COLUMNS_FIELD)->getType()->get(ArrayOfType::ATTR_MAX_ELEMENTS));

        $this->testProcess(
                [
                        'columns' => ['1', '2'],
                        'rows'    => ['9:00'],
                        'cells'   => [
                                ['open', 'closed'],
                        ],
                ],
                TestBusinessHoursTimetableCell::collection([
                        new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(9), $open),
                        new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(9), $closed),
                ])
        );

        $this->testValidation(
                [
                        'columns' => ['1'],
                        'rows'    => ['9:00'],
                        'cells'   => [
                                ['open'],
                        ],
                ],
                [
                        new Message(MinArrayLengthValidator::MESSAGE,
                                ['field' => 'Columns', 'input' => ['1'], 'length' => 2]),
                        new Message(MinArrayLengthValidator::MESSAGE,
                                ['field' => 'Cells', 'input' => [['open']], 'length' => 2, 'key' => 0]),
                ]
        );

        $this->testValidation(
                [
                        'columns' => ['1', '2', '3', '4'],
                        'rows'    => ['9:00'],
                        'cells'   => [
                                ['open', 'open', 'closed', 'open'],
                        ],
                ],
                [
                        new Message(MaxArrayLengthValidator::MESSAGE,
                                ['field' => 'Columns', 'input' => ['1', '2', '3', '4'], 'length' => 3]),
                        new Message(MaxArrayLengthValidator::MESSAGE,
                                ['field' => 'Cells', 'input' => [['open', 'open', 'closed', 'open']], 'length' => 3, 'key' => 0]),
                ]
        );
    }

    public function testRowAmountValidation()
    {
        $open   = TestBusinessAvailability::open();
        $closed = TestBusinessAvailability::closed();

        $this->loadFieldType(
                $this->buildFieldType()
                        ->with(TableType::ATTR_MIN_ROWS, 2)
                        ->with(TableType::ATTR_MAX_ROWS, 3)
        );

        $this->assertSame(2, $this->type->getForm()->getField(TableType::ROWS_FIELD)->getType()->get(ArrayOfType::ATTR_MIN_ELEMENTS));
        $this->assertSame(3, $this->type->getForm()->getField(TableType::ROWS_FIELD)->getType()->get(ArrayOfType::ATTR_MAX_ELEMENTS));

        $this->testProcess(
                [
                        'columns' => ['1'],
                        'rows'    => ['9:00', '10:00'],
                        'cells'   => [
                                ['open'],
                                ['closed'],
                        ],
                ],
                TestBusinessHoursTimetableCell::collection([
                        new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(9), $open),
                        new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(10), $closed),
                ])
        );

        $this->testValidation(
                [
                        'columns' => ['1'],
                        'rows'    => ['9:00'],
                        'cells'   => [
                                ['open'],
                        ],
                ],
                [
                        new Message(MinArrayLengthValidator::MESSAGE,
                                ['field' => 'Rows', 'input' => ['9:00'], 'length' => 2]),
                        new Message(MinArrayLengthValidator::MESSAGE,
                                ['field' => 'Cells', 'input' => [['open']], 'length' => 2]),
                ]
        );

        $this->testValidation(
                [
                        'columns' => ['1'],
                        'rows'    => ['9:00', '10:00', '11:00', '12:00'],
                        'cells'   => [
                                ['open'],
                                ['closed'],
                                ['open'],
                                ['closed'],
                        ],
                ],
                [
                        new Message(MaxArrayLengthValidator::MESSAGE,
                                ['field' => 'Rows', 'input' => ['9:00', '10:00', '11:00', '12:00'], 'length' => 3]),
                        new Message(MaxArrayLengthValidator::MESSAGE,
                                ['field' => 'Cells', 'input' => [['open'], ['closed'], ['open'], ['closed']], 'length' => 3]),
                ]
        );
    }
}