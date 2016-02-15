<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateRange;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The date range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeMapper extends DateOrTimeRangeMapper
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
        $map->type(DateRange::class);

        $map->embedded(DateRange::START)->using(new DateMapper($this->startColumnName));
        $map->embedded(DateRange::END)->using(new DateMapper($this->endColumnName));
    }
}