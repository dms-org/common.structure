<?php

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The date time range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeMapper extends DateOrTimeRangeMapper
{
    /**
     * @inheritDoc
     */
    public function __construct($startColumnName = 'start_date', $endColumnName = 'end_date')
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
        $map->type(DateTimeRange::class);

        $map->embedded(DateTimeRange::START)->using(new DateTimeMapper($this->startColumnName));
        $map->embedded(DateTimeRange::END)->using(new DateTimeMapper($this->endColumnName));
    }
}