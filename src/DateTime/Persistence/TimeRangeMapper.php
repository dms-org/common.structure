<?php

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\TimeRange;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The time range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeMapper extends DateOrTimeRangeMapper
{
    /**
     * @inheritDoc
     */
    public function __construct($startColumnName = 'start_time', $endColumnName = 'end_time')
    {
        parent::__construct($startColumnName, $endColumnName);
    }

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(TimeRange::class);

        $map->embedded(TimeRange::START)->using(new TimeOfDayMapper($this->startColumnName));
        $map->embedded(TimeRange::END)->using(new TimeOfDayMapper($this->endColumnName));
    }
}