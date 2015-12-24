<?php

namespace Dms\Common\Structure\Type\Persistence;

use Dms\Common\Structure\Type\StringValueObject;
use Dms\Core\Persistence\Db\Mapping\Definition\Column\ColumnTypeDefiner;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;

/**
 * The string value object mapper.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class StringValueObjectMapper extends IndependentValueObjectMapper
{
    /**
     * @var string
     */
    protected $columnName;

    /**
     * StringValueObjectMapper constructor.
     *
     * @param string $columnName
     */
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
        $map->type($this->classType());

        $this->defineStringColumnType($map->property(StringValueObject::STRING)->to($this->columnName));
    }

    /**
     * Gets the mapped class type.
     *
     * @return string
     */
    abstract protected function classType();

    /**
     * Defines the column type for the string property.
     *
     * @param ColumnTypeDefiner $stringColumn
     *
     * @return void
     */
    abstract protected function defineStringColumnType(ColumnTypeDefiner $stringColumn);
}