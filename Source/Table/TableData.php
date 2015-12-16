<?php

namespace Iddigital\Cms\Common\Structure\Table;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Exception\TypeMismatchException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;
use Iddigital\Cms\Core\Model\Type\Builder\Type;
use Iddigital\Cms\Core\Model\Type\IType;
use Iddigital\Cms\Core\Model\ValueObjectCollection;
use Iddigital\Cms\Core\Util\Debug;

/**
 * The table data value object base class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TableData extends ValueObject
{
    /**
     * @var IType
     */
    protected $columnKeyType;

    /**
     * @var IType|null
     */
    protected $rowKeyType;

    /**
     * @var IType
     */
    protected $cellType;

    /**
     * @var TableDataColumn[]
     */
    protected $columns;

    /**
     * @var \SplObjectStorage
     */
    protected $columnCellIndexMap;

    /**
     * @var mixed[]
     */
    protected $columnIndexKeyMap;

    /**
     * @var TableDataRow[]
     */
    protected $rows;

    /**
     * TableData constructor.
     *
     * @param array $columnKeys
     * @param Row[] $rows
     *
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    public function __construct(array $columnKeys, array $rows = [])
    {
        InvalidArgumentException::verifyAllInstanceOf(__METHOD__, 'rows', $rows, Row::class);

        parent::__construct();

        $this->loadTableData($columnKeys, $rows);
    }

    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->columnKeyType)->asObject(IType::class);

        $class->property($this->rowKeyType)->nullable()->asObject(IType::class);

        $class->property($this->cellType)->asObject(IType::class);

        $class->property($this->columns)->asArrayOf(Type::object(TableDataColumn::class));

        $class->property($this->columnCellIndexMap)->ignore();

        $class->property($this->columnIndexKeyMap)->asArrayOf(Type::mixed());

        $class->property($this->rows)->asArrayOf(Type::object(TableDataRow::class));
    }

    /**
     * @param array $columnKeys
     * @param Row[] $rows
     *
     * @return void
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    protected function loadTableData(array $columnKeys, array $rows)
    {
        $this->columnKeyType = $this->columnKeyType();
        $this->rowKeyType    = $this->rowKeyType();
        $this->cellType      = $this->cellType();

        $columnCellIndexMap = new \SplObjectStorage();
        $index              = 0;

        $tableDataColumns  = [];
        $columnIndexKeyMap = [];

        foreach ($columnKeys as $columnKey) {
            if (!$this->columnKeyType->isOfType($columnKey)) {
                throw TypeMismatchException::format(
                        'Invalid column key passed to %s: expecting type of %s, %s found',
                        __METHOD__, $this->columnKeyType->asTypeString(), Debug::getType($columnKey)
                );
            }

            $column                      = new TableDataColumn($columnKey, $this->getColumnLabel($columnKey));
            $tableDataColumns[$index]    = $column;
            $columnIndexKeyMap[$index]   = $columnKey;
            $columnCellIndexMap[$column] = $index;
            $index++;
        }

        $this->columns            = $tableDataColumns;
        $this->columnCellIndexMap = $columnCellIndexMap;
        $this->columnIndexKeyMap  = $columnIndexKeyMap;
        $this->rows               = $this->loadRows($rows);
    }

    /**
     * @param Row[] $rows
     *
     * @return TableDataRow[]
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    protected function loadRows(array $rows)
    {
        $amountOfColumns = count($this->columns);
        $tableDataRows   = [];

        foreach ($rows as $key => $row) {
            $rowKey     = $row->getKey();
            $cellValues = array_values($row->getCellValues());

            if ($this->rowKeyType === null && $rowKey !== null) {
                throw TypeMismatchException::format(
                        'Invalid row key found in %s: expecting null, %s found',
                        __METHOD__, Debug::getType($rowKey)
                );
            } elseif ($this->rowKeyType !== null && !$this->rowKeyType->isOfType($rowKey)) {
                throw TypeMismatchException::format(
                        'Invalid row key found in %s: expecting type of %s, %s found',
                        __METHOD__, $this->rowKeyType->asTypeString(), Debug::getType($rowKey)
                );
            }

            if (count($cellValues) !== $amountOfColumns) {
                throw InvalidArgumentException::format(
                        'Invalid row passed to %s: expecting %d cell values, %d given at index \'%s\'',
                        __METHOD__, $amountOfColumns, count($cellValues), $key
                );
            }

            foreach ($cellValues as $cellValue) {
                if (!$this->cellType->isOfType($cellValue)) {
                    throw TypeMismatchException::format(
                            'Invalid data passed to %s: invalid cell value found, expecting type of %s, %s found',
                            __METHOD__, $this->cellType->asTypeString(), Debug::getType($cellValue)
                    );
                }
            }

            $tableDataRows[] = new TableDataRow(
                    $this->columnCellIndexMap,
                    $this->rowKeyType ? $this->getRowLabel($rowKey) : null,
                    $rowKey,
                    $cellValues
            );
        }

        return $tableDataRows;
    }

    /**
     * @return IType
     */
    abstract protected function columnKeyType();

    /**
     * @return IType|null
     */
    abstract protected function rowKeyType();

    /**
     * @return IType
     */
    abstract protected function cellType();

    /**
     * @param mixed $columnKey
     *
     * @return string
     */
    abstract protected function getColumnLabel($columnKey);

    /**
     * @param mixed $rowKey
     *
     * @return string
     */
    abstract protected function getRowLabel($rowKey);

    /**
     * @return TableDataColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @return TableDataRow[]|mixed[][]
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Returns a new table with the supplied rows added.
     *
     * @param Row[] $rows
     *
     * @return static
     */
    public function withRows(array $rows)
    {
        InvalidArgumentException::verifyAllInstanceOf(__METHOD__, 'rows', $rows, Row::class);

        $clone = clone $this;
        $clone->hydrate([
                'rows' => array_merge($this->rows, $this->loadRows($rows))
        ]);

        return $clone;
    }

    /**
     * Gets the table data as a collection of table cell value objects.
     *
     * Returns the cells in the order of their column then their row.
     *
     * @return ValueObjectCollection
     */
    final public function asCellCollection()
    {
        $cellGroups = [];

        foreach ($this->rows as $row) {
            $rowKey = $row->getKey();

            foreach ($row->getCellValues() as $columnIndex => $cellValue) {
                $cellGroups[$columnIndex][] = TableDataCell::create(
                        $this->columnIndexKeyMap[$columnIndex],
                        $rowKey,
                        $cellValue
                );
            }
        }

        ksort($cellGroups);
        $cells = [];

        foreach ($cellGroups as $cellGroup) {
            foreach ($cellGroup as $cell) {
                $cells[] = $cell;
            }
        }

        return TableDataCell::collection($cells);
    }

    /**
     * Loads a collection of table cell value objects into the table structure.
     *
     * NOTE: This exists for persistence purposes only.
     *
     * @param ValueObjectCollection|TableDataCell[] $cells
     *
     * @return static
     * @throws InvalidArgumentException
     * @throws TypeMismatchException
     */
    final public function hydrateFromCellCollection(ValueObjectCollection $cells)
    {
        if (!TableDataCell::collectionType()->isOfType($cells)) {
            throw TypeMismatchException::format(
                    'Invalid collection passed to %s: expecting type of %s, %s given',
                    __METHOD__, TableDataCell::collectionType()->asTypeString(), Type::from($cells)->asTypeString()
            );
        }

        $columnKeys = [];
        $rowKeys    = [];
        $rowData    = [];

        foreach ($cells as $cell) {
            // TODO: improve column/row hashing mechanism
            $columnHash = serialize($cell->columnKey);
            $rowHash    = serialize($cell->rowKey);

            $columnKeys[$columnHash]        = $cell->columnKey;
            $rowKeys[$rowHash]              = $cell->rowKey;
            $rowData[$rowHash][$columnHash] = $cell->cellValue;
        }

        $rows               = [];
        $columnHashIndexMap = array_flip(array_keys($columnKeys));

        foreach ($rowData as $rowKeyHash => $row) {
            $cellValues = [];
            foreach ($row as $columnHash => $cellValue) {
                $cellValues[$columnHashIndexMap[$columnHash]] = $cellValue;
            }

            $rows[] = new Row(
                    $rowKeys[$rowKeyHash],
                    $cellValues
            );
        }

        $this->loadTableData(array_values($columnKeys), $rows);
    }
}