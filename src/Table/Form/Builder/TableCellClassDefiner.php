<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table\Form\Builder;

use Dms\Common\Structure\Table\TableDataCell;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The table data cell class definer.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableCellClassDefiner
{
    /**
     * @var FieldBuilderBase
     */
    protected $fieldBuilder;

    /**
     * TableCellClassDefiner constructor.
     *
     * @param FieldBuilderBase $fieldBuilder
     */
    public function __construct(FieldBuilderBase $fieldBuilder)
    {
        $this->fieldBuilder = $fieldBuilder;
    }

    /**
     * Defines the cell class for the table.
     *
     * @see TableDataCell
     *
     * @param string $tableDataCellClassName
     *
     * @return TableColumnFieldDefiner
     * @throws InvalidArgumentException
     */
    public function withDataCell(string $tableDataCellClassName) : TableColumnFieldDefiner
    {
        if (!is_subclass_of($tableDataCellClassName, TableDataCell::class, true)) {
            throw InvalidArgumentException::format(
                    'Invalid class supplied to %s: expecting subclass of %s, %s given',
                    __METHOD__, TableDataCell::class, $tableDataCellClassName
            );
        }

        return new TableColumnFieldDefiner($this->fieldBuilder, $tableDataCellClassName);
    }
}