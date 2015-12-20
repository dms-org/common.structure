<?php

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The date time value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $columnName;

    public function __construct($columnName = 'datetime')
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
        $map->type(DateTime::class);

        $map->property(DateTime::DATE_TIME)->to($this->columnName)->asDateTime();
    }
}