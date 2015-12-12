<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\DateRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The date range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeMapper extends DateOrTimeRangeMapper
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
        $map->type(DateRange::class);

        $map->embedded(DateRange::START)->using(new DateMapper($this->startColumnName));
        $map->embedded(DateRange::END)->using(new DateMapper($this->endColumnName));
    }
}