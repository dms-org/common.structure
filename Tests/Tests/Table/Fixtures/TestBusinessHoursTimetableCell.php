<?php

namespace Dms\Common\Structure\Tests\Table\Fixtures;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Table\TableData;
use Dms\Common\Structure\Table\Timetable\TimetableDataCell;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursTimetableCell extends TimetableDataCell
{
    const OPENING_HOUR = 9;
    const CLOSING_HOUR = 17;

    /**
     * @var TestBusinessAvailability
     */
    public $cellValue;

    /**
     * TestBusinessHoursTimetableCell constructor.
     *
     * @param DayOfWeek                $columnKey
     * @param TimeOfDay                $rowKey
     * @param TestBusinessAvailability $cellValue
     */
    public function __construct(DayOfWeek $columnKey, TimeOfDay $rowKey, TestBusinessAvailability $cellValue)
    {
        parent::__construct($columnKey, $rowKey, $cellValue);
    }

    /**
     * Defines the structure of this cell class.
     *
     * @param ClassDefinition $class
     */
    protected function defineCell(ClassDefinition $class)
    {
        $class->property($this->cellValue)->asObject(TestBusinessAvailability::class);
    }

    /**
     * @return TableData
     */
    public static function defaultTimetable()
    {
        $cells = [];

        foreach (DayOfWeek::getAll() as $day) {
            foreach (range(0, 23) as $hour) {
                if ($day->isWeekDay() && $hour >= self::OPENING_HOUR && $hour <= self::CLOSING_HOUR) {
                    $status = TestBusinessAvailability::open();
                } else {
                    $status = TestBusinessAvailability::closed();
                }

                $cells[] = new self($day, new TimeOfDay($hour), $status);
            }
        }

        return self::collection($cells);
    }
}