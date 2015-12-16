<?php

namespace Iddigital\Cms\Common\Structure\Table\Timetable;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\Table\TableData;
use Iddigital\Cms\Core\Model\Type\IType;

/**
 * The timetable data value object base class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TimetableData extends TableData
{
    /**
     * @return IType
     */
    protected function columnKeyType()
    {
        return DayOfWeek::type();
    }

    /**
     * @return IType|null
     */
    protected function rowKeyType()
    {
        return TimeOfDay::type();
    }

    /**
     * @param DayOfWeek $columnKey
     *
     * @return string
     */
    protected function getColumnLabel($columnKey)
    {
        return $columnKey->getShortName();
    }

    /**
     * @param TimeOfDay $rowKey
     *
     * @return string
     */
    protected function getRowLabel($rowKey)
    {
        return $rowKey->format('g:i A');
    }
}