<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Fixtures;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\Table\Row;
use Iddigital\Cms\Common\Structure\Table\TableDataRow;
use Iddigital\Cms\Common\Structure\Table\Timetable\TimetableData;
use Iddigital\Cms\Core\Model\Type\IType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursTimetableData extends TimetableData
{
    const OPENING_HOUR = 9;
    const CLOSING_HOUR = 17;

    /**
     * TestBusinessHoursTimetableData constructor.
     *
     * @param Row[] $rows
     */
    public function __construct(array $rows)
    {
        parent::__construct(DayOfWeek::getAll(), $rows);
    }

    /**
     * @return IType
     */
    protected function cellType()
    {
        return TestBusinessAvailability::type();
    }

    /**
     * @return TableDataRow[]|TestBusinessAvailability[][]
     */
    public function getRows()
    {
        return parent::getRows();
    }


    /**
     * @return TestBusinessHoursTimetableData
     */
    public static function defaultTimetable()
    {
        $rows = [];

        foreach (range(0, 23) as $hour) {
            if ($hour >= self::OPENING_HOUR && $hour <= self::CLOSING_HOUR) {
                $status = TestBusinessAvailability::open();
            } else {
                $status = TestBusinessAvailability::closed();
            }

            $rows[] = new Row(new TimeOfDay($hour), array_fill(0, 5, $status) + array_fill(5, 2, TestBusinessAvailability::closed()));
        }

        return new self($rows);
    }
}