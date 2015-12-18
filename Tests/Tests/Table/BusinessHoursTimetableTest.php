<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\Table\TableData;
use Iddigital\Cms\Common\Structure\Table\TableDataColumn;
use Iddigital\Cms\Common\Structure\Table\TableDataRow;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Exception\TypeMismatchException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class BusinessHoursTimetableTest extends CmsTestCase
{
    /**
     * @var TableData
     */
    protected $table;

    public function setUp()
    {
        $this->table = TestBusinessHoursTimetableCell::defaultTimetable();
    }

    public function testColumns()
    {
        $columns = $this->table->getColumns();

        $this->assertCount(7, $columns);
        $this->assertContainsOnlyInstancesOf(TableDataColumn::class, $columns);

        foreach ($columns as $column) {
            $this->assertInstanceOf(DayOfWeek::class, $column->getKey());
            $this->assertContains($column->getLabel(), DayOfWeek::getShortNameMap());
        }
    }

    public function testRows()
    {
        $rows = $this->table->getRows();

        $this->assertCount(24, $rows);
        $this->assertContainsOnlyInstancesOf(TableDataRow::class, $rows);

        foreach ($rows as $row) {
            /** @var TimeOfDay $hour */
            $hour = $row->getKey();
            $this->assertInstanceOf(TimeOfDay::class, $hour);

            foreach ($this->table->getColumns() as $column) {
                /** @var DayOfWeek $day */
                $day = $column->getKey();
                $this->assertInstanceOf(DayOfWeek::class, $day);

                if ($day->isWeekEnd()) {
                    $this->assertEquals(TestBusinessAvailability::closed(), $row[$column]);
                } elseif ($hour->getHour() >= TestBusinessHoursTimetableCell::OPENING_HOUR && $hour->getHour() <= TestBusinessHoursTimetableCell::CLOSING_HOUR) {
                    $this->assertEquals(TestBusinessAvailability::open(), $row[$column]);
                } else {
                    $this->assertEquals(TestBusinessAvailability::closed(), $row[$column]);
                }
            }
        }
    }

    public function testColumnIsset()
    {
        $this->assertThrows(function () {
            isset($this->table->getRows()[0]['abc']);
        }, TypeMismatchException::class);

        $row = $this->table->getRows()[0];
        $this->assertSame(false, isset($row[$this->getMockBuilder(TableDataColumn::class)->disableOriginalConstructor()->getMock()]));
    }

    public function testColumnGetters()
    {
        $this->assertSame(true, $this->table->hasColumn(DayOfWeek::monday()));
        $this->assertSame(true, $this->table->hasColumn(DayOfWeek::tuesday()));
        $this->assertSame(false, $this->table->hasColumn(
                $this->getMockBuilder(DayOfWeek::class)->disableOriginalConstructor()->getMock()
        ));

        $this->assertThrows(function () {
            $this->table->hasRow('abc');
        }, TypeMismatchException::class);

        $this->assertInstanceOf(TableDataColumn::class, $this->table->getColumn(DayOfWeek::monday()));
        $this->assertInstanceOf(TableDataColumn::class, $this->table->getColumn(DayOfWeek::tuesday()));
        $this->assertThrows(function () {
            $this->table->getColumn($this->getMockBuilder(DayOfWeek::class)->disableOriginalConstructor()->getMock());
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            $this->table->getColumn('abc');
        }, TypeMismatchException::class);
    }

    public function testRowGetters()
    {
        $this->assertSame(true, $this->table->hasRow(new TimeOfDay(1)));
        $this->assertSame(true, $this->table->hasRow(new TimeOfDay(12)));
        $this->assertSame(false, $this->table->hasRow(new TimeOfDay(12, 0, 1)));

        $this->assertThrows(function () {
            $this->table->hasRow('abc');
        }, TypeMismatchException::class);

        $this->assertInstanceOf(TableDataRow::class, $this->table->getRow(new TimeOfDay(1)));
        $this->assertInstanceOf(TableDataRow::class, $this->table->getRow(new TimeOfDay(12)));
        $this->assertThrows(function () {
            $this->table->getRow(new TimeOfDay(12, 0, 1));
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            $this->table->getRow('abc');
        }, TypeMismatchException::class);
    }

    public function testCellGetters()
    {
        $this->assertSame(true, $this->table->hasCell(DayOfWeek::monday(), new TimeOfDay(1)));
        $this->assertSame(true, $this->table->hasCell(DayOfWeek::tuesday(), new TimeOfDay(3)));
        $this->assertSame(false, $this->table->hasCell(DayOfWeek::tuesday(), new TimeOfDay(3, 10, 00)));

        $this->assertThrows(function () {
            $this->table->hasCell('abc', new TimeOfDay(3));
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            $this->table->hasCell(DayOfWeek::tuesday(), 'abc');
        }, TypeMismatchException::class);

        $this->assertInstanceOf(TestBusinessAvailability::class, $this->table->getCell(DayOfWeek::monday(), new TimeOfDay(1)));
        $this->assertInstanceOf(TestBusinessAvailability::class, $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(3)));

        $this->assertThrows(function () {
            $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(3, 10, 00));
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            $this->table->getCell('abc', new TimeOfDay(3));
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            $this->table->getCell(DayOfWeek::tuesday(), 'abc');
        }, TypeMismatchException::class);

    }

    public function testInvalidColumn()
    {
        $this->assertThrows(function () {
            $this->table->getRows()[0]['abc'];
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            $this->table->getRows()[0][$this->getMockBuilder(TableDataColumn::class)->disableOriginalConstructor()->getMock()];
        }, InvalidArgumentException::class);
    }

    public function testMissingCellIsReplacedWithNull()
    {
        $this->table = TestBusinessHoursTimetableCell::collection([
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(12), TestBusinessAvailability::open()),
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(13), TestBusinessAvailability::open()),
                //
                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(12), TestBusinessAvailability::open()),
        ]);

        $this->assertEquals(TestBusinessAvailability::open(), $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(12)));
        $this->assertSame(null, $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(13)));
    }

    public function testDuplicateCellsAreRemoved()
    {
        $this->table = TestBusinessHoursTimetableCell::collection([
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(12), TestBusinessAvailability::open()),
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(12), TestBusinessAvailability::closed()),
        ]);

        $this->assertCount(1, $this->table);
        $this->assertEquals(TestBusinessAvailability::closed(), $this->table->getCell(DayOfWeek::monday(), new TimeOfDay(12)));
    }

    public function testAddingCell()
    {
        $this->table = TestBusinessHoursTimetableCell::collection([
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(12), TestBusinessAvailability::open()),
                new TestBusinessHoursTimetableCell(DayOfWeek::monday(), new TimeOfDay(13), TestBusinessAvailability::open()),
                //
                new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(12), TestBusinessAvailability::open()),
        ]);

        $this->assertSame(null, $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(13)));

        $this->table[] = new TestBusinessHoursTimetableCell(DayOfWeek::tuesday(), new TimeOfDay(13), TestBusinessAvailability::closed());

        $this->assertEquals(TestBusinessAvailability::closed(), $this->table->getCell(DayOfWeek::tuesday(), new TimeOfDay(13)));
    }
}