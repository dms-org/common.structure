<?php

namespace Dms\Common\Structure;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\Table\Timetable\TimetableDataCell;

/**
 * The field builder class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Field
{
    /**
     * Creates a field with the supplied name and label.
     *
     * @param string $name
     * @param string $label
     *
     * @return FieldBuilder
     */
    public static function create($name, $label)
    {
        return new FieldBuilder($name, $label);
    }

    /**
     * Creates a field for use as an element of another array field
     * with the supplied name and label.
     *
     * @return FieldBuilder
     */
    public static function element()
    {
        return self::create('__element', '__element');
    }

    /**
     * Creates a field for use as a field type placeholder.
     *
     * @return FieldBuilder
     */
    public static function forType()
    {
        return self::create('__type', '__type');
    }
}

// TODO: test
Field::create('timetable', 'Timetable')
        ->table()
        ->withDataCell(TimetableDataCell::class)
        ->withPredefinedColumnValues(DayOfWeek::getOptions())
        ->withRowKeyAs(Field::forType()->time()->required())
        ->withCellValuesAs(Field::forType()->string())
        ->maxRows(3);