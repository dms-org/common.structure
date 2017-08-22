<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Exception\TypeMismatchException;
use Dms\Core\Model\Collection;
use Dms\Core\Model\Type\IType;
use Dms\Core\Model\ValueObjectCollection;
use Dms\Core\Util\Debug;
use Dms\Core\Util\Hashing\ValueHasher;
use Pinq\Iterators\IIteratorScheme;

/**
 * The table cell data collection class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableData extends ValueObjectCollection
{
    /**
     * @var string
     */
    protected $cellClass;

    /**
     * @var IType
     */
    protected $columnKeyType;

    /**
     * @var IType
     */
    protected $rowKeyType;

    /**
     * @var TableDataColumn[]
     */
    protected $columns;

    /**
     * @var TableDataRow[]
     */
    protected $rows;

    /**
     * TableData constructor.
     *
     * @param string               $cellType
     * @param TableDataCell[]      $cells
     * @param IIteratorScheme|null $scheme
     * @param Collection|null      $source
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $cellType,
        array $cells,
        IIteratorScheme $scheme = null,
        Collection $source = null
    ) {
        /** @var TableDataCell $cellType */
        if (!is_subclass_of($cellType, TableDataCell::class, true)) {
            throw InvalidArgumentException::format(
                'Invalid cell class type supplied to %s: expecting subclass of %s, %s given',
                __METHOD__, TableDataCell::class, $cellType
            );
        }

        parent::__construct($cellType, [], $scheme, $source);

        $cellDefinition      = $cellType::definition();
        $this->columnKeyType = $cellDefinition->getProperty(TableDataCell::COLUMN_KEY)->getType();
        $this->rowKeyType    = $cellDefinition->getProperty(TableDataCell::ROW_KEY)->getType();

        $this->updateElements(new \ArrayIterator($cells));
    }

    public function createLazyCollection(callable $callback)
    {
        return new LazyTableData($this->getObjectType(), $callback);
    }

    protected function updateElements(\Traversable $elements)
    {
        $uniqueCells = [];

        /** @var TableDataCell $cell */
        foreach ($elements as $cell) {
            $uniqueCells[ValueHasher::hash($cell->rowKey) . '::' . ValueHasher::hash($cell->columnKey)] = $cell;
        }

        parent::updateElements(new \ArrayIterator($uniqueCells));
        $this->requireReloadOfRowsAndColumns();
    }

    /**
     * @return TableDataCell[]
     */
    public function getAll() : array
    {
        return parent::getAll();
    }

    /**
     * @return void
     */
    protected function requireReloadOfRowsAndColumns()
    {
        $this->columns = null;
        $this->rows    = null;
    }

    /**
     * @return void
     */
    protected function loadColumns()
    {
        if ($this->columns) {
            return;
        }

        $cells = $this->getAll();

        $columns = [];

        foreach ($cells as $cell) {
            $columns[ValueHasher::hash($cell->columnKey)] = new TableDataColumn($cell->columnKey, $cell->getColumnLabel());
        }

        $this->columns = $columns;
    }

    /**
     * @return void
     */
    protected function loadRows()
    {
        if ($this->rows) {
            return;
        }

        $cells = $this->getAll();

        $columns        = [];
        $columnIndexMap = new \SplObjectStorage();

        foreach ($this->getColumns() as $index => $column) {
            $columns[ValueHasher::hash($column->getKey())] = $column;
            $columnIndexMap[$column]                       = $index;
        }

        /** @var TableDataCell[][] $rows */
        $rows = [];

        foreach ($cells as $cell) {
            $rows[ValueHasher::hash($cell->rowKey)][ValueHasher::hash($cell->columnKey)] = $cell;
        }

        foreach ($rows as $key => $cells) {
            /** @var TableDataCell $firstCell */
            $firstCell = reset($cells);

            $cellValues = [];
            foreach ($columns as $columnKeyHash => $column) {
                $cellValues[] = isset($cells[$columnKeyHash])
                    ? $cells[$columnKeyHash]->cellValue
                    : null;
            }

            $rows[$key] = new TableDataRow(
                $columnIndexMap,
                $firstCell->getRowLabel(),
                $firstCell->rowKey,
                array_values($cellValues)
            );
        }

        $this->rows = $rows;
    }

    /**
     * @return TableDataColumn[]
     */
    public function getColumns() : array
    {
        $this->loadColumns();

        return array_values($this->columns);
    }

    /**
     * @return TableDataRow[]
     */
    public function getRows() : array
    {
        $this->loadRows();

        return array_values($this->rows);
    }

    protected function validateRowKey($method, $rowKey)
    {
        if (!$this->rowKeyType->isOfType($rowKey)) {
            throw TypeMismatchException::format(
                'Invalid row key passed to %s: expecting type of %s, %s given',
                $method, $this->rowKeyType->asTypeString(), Debug::getType($rowKey)
            );
        }
    }

    protected function validateColumnKey($method, $columnKey)
    {
        if (!$this->columnKeyType->isOfType($columnKey)) {
            throw TypeMismatchException::format(
                'Invalid column key passed to %s: expecting type of %s, %s given',
                $method, $this->columnKeyType->asTypeString(), Debug::getType($columnKey)
            );
        }
    }

    /**
     * Returns whether the table data contains a column with the supplied key.
     *
     * @param mixed $columnKey
     *
     * @return bool
     * @throws TypeMismatchException
     */
    public function hasColumn($columnKey) : bool
    {
        $this->validateColumnKey(__METHOD__, $columnKey);
        $this->loadColumns();

        $columnHash = ValueHasher::hash($columnKey);

        return isset($this->columns[$columnHash]);
    }

    /**
     * Gets the table column with the supplied key.
     *
     * @param mixed $columnKey
     *
     * @return TableDataColumn
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    public function getColumn($columnKey) : TableDataColumn
    {
        $this->validateColumnKey(__METHOD__, $columnKey);
        $this->loadColumns();

        $columnHash = ValueHasher::hash($columnKey);

        if (!isset($this->columns[$columnHash])) {
            throw InvalidArgumentException::format(
                'Invalid column key supplied to %s: expecting one of hashes (%s), value with \'%s\' hash given',
                __METHOD__, Debug::formatValues(array_keys($this->columns)), $columnHash
            );
        }

        return $this->columns[$columnHash];
    }

    /**
     * Returns whether the table data contains a row with the supplied key.
     *
     * @param mixed $rowKey
     *
     * @return bool
     * @throws TypeMismatchException
     */
    public function hasRow($rowKey) : bool
    {
        $this->validateRowKey(__METHOD__, $rowKey);
        $this->loadRows();

        $rowHash = ValueHasher::hash($rowKey);

        return isset($this->rows[$rowHash]);
    }

    /**
     * Gets the table row with the supplied key.
     *
     * @param mixed $rowKey
     *
     * @return TableDataRow
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    public function getRow($rowKey) : TableDataRow
    {
        $this->validateRowKey(__METHOD__, $rowKey);
        $this->loadRows();

        $rowHash = ValueHasher::hash($rowKey);

        if (!isset($this->rows[$rowHash])) {
            throw InvalidArgumentException::format(
                'Invalid row key supplied to %s: expecting one of hashes (%s), value with \'%s\' hash given',
                __METHOD__, Debug::formatValues(array_keys($this->rows)), $rowHash
            );
        }

        return $this->rows[$rowHash];
    }

    /**
     * Returns whether their is a cell value at the supplied row and column.
     *
     * @param mixed $columnKey
     * @param mixed $rowKey
     *
     * @return bool
     * @throws TypeMismatchException
     */
    public function hasCell($columnKey, $rowKey) : bool
    {
        $this->validateColumnKey(__METHOD__, $columnKey);
        $this->validateRowKey(__METHOD__, $rowKey);

        $this->loadColumns();
        $this->loadRows();

        $columnHash = ValueHasher::hash($columnKey);
        if (!isset($this->columns[$columnHash])) {
            return false;
        }

        $rowHash = ValueHasher::hash($rowKey);
        if (!isset($this->rows[$rowHash])) {
            return false;
        }

        return true;
    }

    /**
     * Gets the value of the cell or NULL if the cell does not exist.
     *
     * @param mixed $columnKey
     * @param mixed $rowKey
     *
     * @return mixed
     * @throws TypeMismatchException
     */
    public function getCell($columnKey, $rowKey)
    {
        $column = $this->getColumn($columnKey);
        $row    = $this->getRow($rowKey);

        return $row[$column];
    }

    /**
     * @inheritdoc
     */
    public function apply(callable $function)
    {
        parent::apply($function);
        $this->requireReloadOfRowsAndColumns();
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($index)
    {
        parent::offsetUnset($index);
        $this->requireReloadOfRowsAndColumns();
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($index, $value)
    {
        parent::offsetSet($index, $value);
        $this->requireReloadOfRowsAndColumns();
    }
}