<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\Time;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The time value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $columnName;

    public function __construct($columnName)
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
        $map->type(Time::class);

        $map->property(Time::DATE_TIME)->to($this->columnName)->asTime();
    }
}