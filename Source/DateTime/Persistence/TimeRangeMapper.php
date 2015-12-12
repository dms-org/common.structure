<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\TimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The time range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeMapper extends DateOrTimeRangeMapper
{
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

        $map->embedded(TimeRange::START)->using(new TimeMapper($this->startColumnName));
        $map->embedded(TimeRange::END)->using(new TimeMapper($this->endColumnName));
    }
}