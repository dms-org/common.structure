<?php

namespace Iddigital\Cms\Common\Structure\Table;

use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;

/**
 * The table data cell value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableDataCell extends ValueObject
{
    const COLUMN_KEY = 'columnKey';
    const ROW_KEY = 'rowKey';
    const CELL_VALUE = 'cellValue';

    /**
     * @var mixed
     */
    public $columnKey;

    /**
     * @var mixed
     */
    public $rowKey;

    /**
     * @var mixed
     */
    public $cellValue;

    /**
     * @param mixed $columnKey
     * @param mixed $rowKey
     * @param mixed $cellValue
     *
     * @return TableDataCell
     */
    public static function create($columnKey, $rowKey, $cellValue)
    {
        $cell = self::construct();

        $cell->columnKey = $columnKey;
        $cell->rowKey    = $rowKey;
        $cell->cellValue = $cellValue;

        return $cell;
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->columnKey)->asMixed();
        $class->property($this->rowKey)->asMixed();
        $class->property($this->cellValue)->asMixed();
    }
}