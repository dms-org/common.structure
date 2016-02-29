<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\DateTime\Form\TimeOfDayType;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Field;
use Dms\Common\Structure\Table\Form\TableType;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Dms\Common\Structure\Tests\Table\Fixtures\TestStringDataCell;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Form\Field\Type\EnumType;
use Dms\Core\Form\Field\Type\FloatType;
use Dms\Core\Form\Field\Type\IntType;
use Dms\Core\Form\Field\Type\StringType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableFieldTest extends CmsTestCase
{
    public function testTableField()
    {
        /** @var TableType $type */
        $type = Field::forType()->table()
            ->withDataCell(TestStringDataCell::class)
            ->withColumnKeyAs(Field::forType()->string()->required())
            ->withRowKeyAs(Field::forType()->decimal()->required())
            ->withCellValuesAs(Field::forType()->int()->required())
            ->minColumns(2)
            ->maxColumns(4)
            ->minRows(10)
            ->maxRows(100)
            ->build()
            ->getType();

        $this->assertInstanceOf(TableType::class, $type);
        $this->assertInstanceOf(StringType::class, $type->getColumnField()->getType());
        $this->assertInstanceOf(FloatType::class, $type->getRowField()->getType());
        $this->assertInstanceOf(IntType::class, $type->getCellField()->getType());
        $this->assertSame(TestStringDataCell::class, $type->getTableDataCellClass());

        $this->assertArraySubset([
            TableType::ATTR_MIN_COLUMNS => 2,
            TableType::ATTR_MAX_COLUMNS => 4,
            TableType::ATTR_MIN_ROWS    => 10,
            TableType::ATTR_MAX_ROWS    => 100,
        ], $type->attrs());
    }

    public function testPredefinedRowsAndColumns()
    {
        /** @var TableType $type */
        $type = Field::forType()->table()
            ->withDataCell(TestBusinessHoursTimetableCell::class)
            ->withPredefinedColumnValues(Field::forType()->enum(DayOfWeek::class, DayOfWeek::getShortNameMap()), $columnValues = DayOfWeek::getAll())
            ->withPredefinedRowValues(Field::forType()->time(), $rowValues = [
                new TimeOfDay(9),
                new TimeOfDay(10),
                new TimeOfDay(11),
                new TimeOfDay(12),
            ])
            ->withCellValuesAs(Field::forType()->enum(TestBusinessAvailability::class, [
                TestBusinessAvailability::OPEN   => 'Open',
                TestBusinessAvailability::CLOSED => 'Closed',
            ]))
            ->build()
            ->getType();

        $this->assertInstanceOf(TableType::class, $type);
        $this->assertInstanceOf(EnumType::class, $type->getColumnField()->getType());
        $this->assertInstanceOf(TimeOfDayType::class, $type->getRowField()->getType());

        $this->assertArraySubset([
            TableType::ATTR_PREDEFINED_COLUMNS => $columnValues,
            TableType::ATTR_PREDEFINED_ROWS    => $rowValues,
        ], $type->attrs());
    }

    public function testIncrementingIntegerRows()
    {
        /** @var TableType $type */
        $type = Field::forType()->table()
            ->withDataCell(TestStringDataCell::class)
            ->withColumnKeyAs(Field::forType()->string()->required())
            ->withRowKeyAsIncrementingIntegers()
            ->withCellValuesAs(Field::forType()->int()->required())
            ->build()
            ->getType();

        $this->assertInstanceOf(TableType::class, $type);
        $this->assertSame(null, $type->getRowField());
    }
}