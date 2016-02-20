<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table;

use Dms\Core\Model\Object\ValueObject;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Model\Type\CollectionType;
use Dms\Core\Model\Type\IType;

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
     * @param mixed $columnKey
     * @param mixed $rowKey
     * @param mixed $cellValue
     *
     * @return static
     */
    public static function create($columnKey, $rowKey, $cellValue)
    {
        return new static($columnKey, $rowKey, $cellValue);
    }

    /**
     * Gets the type of the of table data collection.
     *
     * @return CollectionType
     */
    public static function collectionType() : CollectionType
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
    public static function collection(array $cells = []) : TableData
    {
        return new TableData(get_called_class(), $cells);
    }

    /**
     * Gets the label for the column of this cell.
     *
     * @return string
     */
    abstract public function getColumnLabel() : string;

    /**
     * Gets the label for the row of this cell.
     *
     * @return string
     */
    abstract public function getRowLabel() : string;
}