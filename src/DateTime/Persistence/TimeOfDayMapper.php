<?php

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The time value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDayMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $columnName;

    public function __construct($columnName = 'time')
    {
        $this->columnName = $columnName;
        parent::__construct();
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
        $map->type(TimeOfDay::class);

        $map->property(TimeOfDay::DATE_TIME)->to($this->columnName)->asTime();
    }
}