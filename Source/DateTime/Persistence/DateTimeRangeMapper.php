<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\DateTimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The date time range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeMapper extends DateOrTimeRangeMapper
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
        $map->type(DateTimeRange::class);

        $map->embedded(DateTimeRange::START)->using(new DateTimeMapper($this->startColumnName));
        $map->embedded(DateTimeRange::END)->using(new DateTimeMapper($this->endColumnName));
    }
}