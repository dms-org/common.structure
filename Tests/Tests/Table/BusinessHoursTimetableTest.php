<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\Table\Row;
use Iddigital\Cms\Common\Structure\Table\TableDataColumn;
use Iddigital\Cms\Common\Structure\Table\TableDataRow;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableData;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Exception\TypeMismatchException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class BusinessHoursTimetableTest extends CmsTestCase
{
    /**
     * @var TestBusinessHoursTimetableData
     */
    protected $table;

    public function setUp()
    {
        $this->table = TestBusinessHoursTimetableData::defaultTimetable();
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
                } elseif ($hour->getHour() >= TestBusinessHoursTimetableData::OPENING_HOUR && $hour->getHour() <= TestBusinessHoursTimetableData::CLOSING_HOUR) {
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

    public function testInvalidColumn()
    {
        $this->assertThrows(function () {
            $this->table->getRows()[0]['abc'];
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            $this->table->getRows()[0][$this->getMockBuilder(TableDataColumn::class)->disableOriginalConstructor()->getMock()];
        }, InvalidArgumentException::class);
    }

    public function testInvalidRows()
    {
        $this->assertThrows(function () {
            new TestBusinessHoursTimetableData(['abc']);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new TestBusinessHoursTimetableData([
                    new Row(new TimeOfDay(1), array_fill(0, 7, new \stdClass()))
            ]);
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            new TestBusinessHoursTimetableData([
                // Requires 7 values per row
                new Row(new TimeOfDay(1), [TestBusinessAvailability::open()])
            ]);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new TestBusinessHoursTimetableData([
                    new Row(null, array_fill(0, 7, TestBusinessAvailability::open()))
            ]);
        }, TypeMismatchException::class);

        $this->assertThrows(function () {
            new TestBusinessHoursTimetableData([
                    new Row(new \stdClass(), array_fill(0, 7, TestBusinessAvailability::open()))
            ]);
        }, TypeMismatchException::class);
    }
}