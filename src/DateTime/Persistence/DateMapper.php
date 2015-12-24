<?php

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\Date;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The date value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $columnName;

    public function __construct($columnName = 'date')
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
        $map->type(Date::class);

        $map->property(Date::DATE_TIME)->to($this->columnName)->asDate();
    }
}