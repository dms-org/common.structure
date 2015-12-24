<?php

namespace Dms\Common\Structure\Table\Form\Processor;

use Dms\Common\Structure\Table\Form\TableType;
use Dms\Common\Structure\Table\TableData;
use Dms\Common\Structure\Table\TableDataCell;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Form\Field\Processor\FieldProcessor;

/**
 * The table data processor.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableDataProcessor extends FieldProcessor
{
    /**
     * @var string|TableDataCell
     */
    private $tableDataCellClass;

    /**
     * TableDataProcessor constructor.
     *
     * @param string $tableDataCellClass
     */
    public function __construct($tableDataCellClass)
    {
        InvalidArgumentException::verify(is_string($tableDataCellClass), 'class must be a string');
        /** @var string|TableDataCell $tableDataCellClass */
        parent::__construct($tableDataCellClass::collectionType());
        $this->tableDataCellClass = $tableDataCellClass;
    }

    /**
     * @param array $input
     * @param array $messages
     *
     * @return mixed
     */
    protected function doProcess($input, array &$messages)
    {
        $columns = $input[TableType::COLUMNS_FIELD];
        $rows    = isset($input[TableType::ROWS_FIELD]) ? $input[TableType::ROWS_FIELD] : null;
        $cells   = $input[TableType::CELLS_FIELD];

        if ($rows === null) {
            // If no row keys, replace with incrementing integers
            $i = 1;
            foreach ($cells as $rowKey => $cellRow) {
                $rows[$rowKey] = $i++;
            }
        }

        $tableCellClass   = $this->tableDataCellClass;
        $tableCellClasses = [];

        foreach ($columns as $columnKey => $columnValue) {
            foreach ($rows as $rowKey => $rowValue) {
                $tableCellClasses[] = $tableCellClass::create($columnValue, $rowValue, $cells[$rowKey][$columnKey]);
            }
        }

        return $tableCellClass::collection($tableCellClasses);
    }

    /**
     * @param TableData $input
     *
     * @return mixed
     */
    protected function doUnprocess($input)
    {
        $columns = [];
        $rows    = [];
        $cells   = [];

        $columnObjects = $input->getColumns();
        $rowObjects    = $input->getRows();

        $columnKey = 0;
        foreach ($columnObjects as $column) {
            $columns[$columnKey] = $column->getKey();
            $columnKey++;
        }

        $rowKey = 0;
        foreach ($rowObjects as $row) {
            $rows[$rowKey] = $row->getKey();

            $columnKey = 0;
            foreach ($columnObjects as $column) {
                $cells[$rowKey][$columnKey] = $row[$column];
                $columnKey++;
            }

            $rowKey++;
        }

        return [
                TableType::COLUMNS_FIELD => $columns,
                TableType::ROWS_FIELD    => $rows,
                TableType::CELLS_FIELD   => $cells,
        ];
    }
}