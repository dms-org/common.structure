<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table\Form\Builder;

use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Form\IField;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Common\Structure\Table\Form\TableType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableRowFieldDefiner
{
    /**
     * @var FieldBuilderBase
     */
    protected $fieldBuilder;

    /**
     * @var string
     */
    protected $cellClassName;

    /**
     * @var IField
     */
    protected $columnField;

    /**
     * TableRowFieldDefiner constructor.
     *
     * @param FieldBuilderBase $fieldBuilder
     * @param string           $cellClassName
     * @param IField           $columnField
     */
    public function __construct(FieldBuilderBase $fieldBuilder, string $cellClassName, IField $columnField)
    {
        $this->fieldBuilder  = $fieldBuilder;
        $this->cellClassName = $cellClassName;
        $this->columnField   = $columnField;
    }

    /**
     * Defines the rows as predefined set of values.
     *
     * @param FieldBuilderBase $field
     * @param array            $rowValues
     *
     * @return TableCellValueFieldDefiner
     */
    public function withPredefinedRowValues(FieldBuilderBase $field, array $rowValues) : TableCellValueFieldDefiner
    {
        $this->fieldBuilder->attr(TableType::ATTR_PREDEFINED_ROWS, array_values($rowValues));
        return $this->withRowKeyAs($field);
    }

    /**
     * Defines the row key as the supplied field.
     *
     * @param FieldBuilderBase $field
     *
     * @return TableCellValueFieldDefiner
     */
    public function withRowKeyAs(FieldBuilderBase $field) : TableCellValueFieldDefiner
    {
        return $this->withRowKeyAsField($field->build());
    }

    /**
     * Defines the row key as the supplied field.
     *
     * @param IField $field
     *
     * @return TableCellValueFieldDefiner
     */
    public function withRowKeyAsField(IField $field) : TableCellValueFieldDefiner
    {
        return new TableCellValueFieldDefiner($this->fieldBuilder, $this->cellClassName, $this->columnField, $field);
    }

    /**
     * Defines the row key to auto-incrementing integers.
     *
     * @return TableCellValueFieldDefiner
     */
    public function withRowKeyAsIncrementingIntegers() : TableCellValueFieldDefiner
    {
        return new TableCellValueFieldDefiner($this->fieldBuilder, $this->cellClassName, $this->columnField);
    }
}