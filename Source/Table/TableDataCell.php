<?php

namespace Iddigital\Cms\Common\Structure\Table;

use Iddigital\Cms\Core\Model\Object\ValueObject;
use Iddigital\Cms\Core\Model\Type\Builder\Type;
use Iddigital\Cms\Core\Model\Type\CollectionType;

/**
 * The table data cell value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TableDataCell extends ValueObject
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
     * TableDataCell constructor.
     *
     * @param mixed $columnKey
     * @param mixed $rowKey
     * @param mixed $cellValue
     */
    public function __construct($columnKey, $rowKey, $cellValue)
    {
        parent::__construct();
        $this->columnKey = $columnKey;
        $this->rowKey    = $rowKey;
        $this->cellValue = $cellValue;
    }

    /**
     * Gets the type of the of table data collection.
     *
     * @return CollectionType
     */
    public static function collectionType()
    {
        return Type::collectionOf(static::type(), TableData::class);
    }

    /**
     * Creates a table data collection with the supplied cells.
     *
     * @param static[] $cells
     *
     * @return TableData
     */
    public static function collection(array $cells = [])
    {
        return new TableData(get_called_class(), $cells);
    }

    /**
     * Gets the label for the column of this cell.
     *
     * @return string
     */
    abstract public function getColumnLabel();

    /**
     * Gets the label for the row of this cell.
     *
     * @return string
     */
    abstract public function getRowLabel();
}