<?php

namespace Iddigital\Cms\Common\Structure\Table\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\Persistence\TimeOfDayMapper;
use Iddigital\Cms\Common\Structure\Table\TableDataCell;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The timetable table data value object base mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TimetableDataMapper extends TableDataMapper
{
    /**
     * Defines the value object mapper for the cells contained within the table.
     *
     * @see TableDataCell
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    final protected function defineCellMapper(MapperDefinition $map)
    {
        $map->relation(TableDataCell::COLUMN_KEY)
                ->asEmbedded()
                ->enum(DayOfWeek::class)
                ->to('day')
                ->usingValuesFromConstants();

        $map->relation(TableDataCell::ROW_KEY)
                ->asEmbedded()
                ->object()
                ->using(new TimeOfDayMapper('time'));

        $this->defineCellDataMapper($map);
    }

    /**
     * Defines the value object mapper for the cells contained within the table.
     *
     * @see TableDataCell
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    abstract protected function defineCellDataMapper(MapperDefinition $map);
}