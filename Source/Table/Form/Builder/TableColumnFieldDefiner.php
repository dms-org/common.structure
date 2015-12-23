<?php

namespace Dms\Common\Structure\Table\Form\Builder;

use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Form\IField;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Common\Structure\Table\Form\TableType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableColumnFieldDefiner
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
     * TableColumnFieldDefiner constructor.
     *
     * @param FieldBuilderBase $fieldBuilder
     * @param string           $cellClassName
     */
    public function __construct(FieldBuilderBase $fieldBuilder, $cellClassName)
    {
        $this->fieldBuilder  = $fieldBuilder;
        $this->cellClassName = $cellClassName;
    }

    /**
     * Defines the columns as predefined set of values.
     *
     * @param array $columnValues
     *
     * @return TableRowFieldDefiner
     */
    public function withPredefinedColumnValues(array $columnValues)
    {
        $this->fieldBuilder->attr(TableType::ATTR_PREDEFINED_COLUMNS, array_values($columnValues));
        return $this->withColumnKeyAs(Field::forType()->custom(Type::mixed(), []));
    }

    /**
     * Defines the column field for the table.
     *
     * @param FieldBuilderBase $field
     *
     * @return TableRowFieldDefiner
     */
    public function withColumnKeyAs(FieldBuilderBase $field)
    {
        return $this->withColumnKeyAsField($field->build());
    }

    /**
     * Defines the column field for the table.
     *
     * @param IField $field
     *
     * @return TableRowFieldDefiner
     */
    public function withColumnKeyAsField(IField $field)
    {
        return new TableRowFieldDefiner($this->fieldBuilder, $this->cellClassName, $field);
    }
}