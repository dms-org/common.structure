<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table;

use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Exception\NotImplementedException;
use Dms\Core\Exception\TypeMismatchException;
use Dms\Core\Util\Debug;

/**
 * The table data row value object class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableDataRow extends Row implements \ArrayAccess
{
    /**
     * @var \SplObjectStorage|TableDataColumn[]
     */
    protected $columnCellIndexMap;

    /**
     * @var string|null
     */
    protected $label;

    /**
     * TableDataRow constructor.
     *
     * @param \SplObjectStorage $columnCellIndexMap
     * @param string|null       $label
     * @param mixed             $rowKey
     * @param array             $cellValues
     */
    public function __construct(\SplObjectStorage $columnCellIndexMap, $label, $rowKey, array $cellValues)
    {
        parent::__construct($rowKey, $cellValues);
        $this->columnCellIndexMap = $columnCellIndexMap;
        $this->label              = $label;
    }

    /**
     * Gets the label of the row.
     *
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return bool
     */
    public function hasLabel() : bool
    {
        return $this->label !== null;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($column)
    {
        TypeMismatchException::verifyInstanceOf(__METHOD__, 'column', $column, TableDataColumn::class);

        return isset($this->columnCellIndexMap[$column]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($column)
    {
        TypeMismatchException::verifyInstanceOf(__METHOD__, 'column', $column, TableDataColumn::class);

        if (!isset($this->columnCellIndexMap[$column])) {
            $columnLabels = [];

            foreach ($this->columnCellIndexMap as $column) {
                $columnLabels[] = $column->getLabel();
            }

            throw InvalidArgumentException::format(
                    'Invalid column supplied to %s: expecting one of columns (%s), \'%s\' given',
                    __METHOD__, Debug::formatValues($columnLabels), $column->getLabel()
            );
        }

        $cellIndex = $this->columnCellIndexMap[$column];

        return $this->cellValues[$cellIndex];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($column, $value)
    {
        throw NotImplementedException::method(__METHOD__);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($column)
    {
        throw NotImplementedException::method(__METHOD__);
    }
}