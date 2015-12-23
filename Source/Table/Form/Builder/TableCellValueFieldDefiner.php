<?php

namespace Dms\Common\Structure\Table\Form\Builder;

use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Form\IField;
use Dms\Common\Structure\Table\Form\TableType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableCellValueFieldDefiner
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
     * @var IField|null
     */
    protected $rowField;

    /**
     * TableCellValueFieldDefiner constructor.
     *
     * @param FieldBuilderBase $fieldBuilder
     * @param string           $cellClassName
     * @param IField           $columnField
     * @param IField|null      $rowField
     */
    public function __construct(FieldBuilderBase $fieldBuilder, $cellClassName, IField $columnField, IField $rowField = null)
    {
        $this->fieldBuilder  = $fieldBuilder;
        $this->cellClassName = $cellClassName;
        $this->columnField   = $columnField;
        $this->rowField      = $rowField;
    }

    /**
     * Defines the cell values as the supplied field.
     *
     * @param FieldBuilderBase $field
     *
     * @return TableFieldBuilder
     */
    public function withCellValuesAs(FieldBuilderBase $field)
    {
        return $this->withCellValuesAsField($field->build());
    }

    /**
     * Defines the cell values as the supplied field.
     *
     * @param IField $field
     *
     * @return TableFieldBuilder
     */
    public function withCellValuesAsField(IField $field)
    {
        return new TableFieldBuilder(
                $this->fieldBuilder
                        ->type(new TableType(
                                $this->cellClassName,
                                $this->columnField,
                                $this->rowField,
                                $field
                        ))
        );
    }
}