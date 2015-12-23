<?php

namespace Dms\Common\Structure\Table\Form;

use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Type\ArrayOfType;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IField;
use Dms\Core\Form\IForm;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Common\Structure\Table\Form\Processor\TableDataProcessor;
use Dms\Common\Structure\Table\Form\Processor\TableStructureValidator;

/**
 * The table field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableType extends InnerFormType
{
    const COLUMNS_FIELD = 'columns';
    const ROWS_FIELD = 'rows';
    const CELLS_FIELD = 'cells';

    const ATTR_MIN_COLUMNS = 'min-columns';
    const ATTR_MAX_COLUMNS = 'max-columns';
    const ATTR_EXACT_COLUMNS = 'exact-columns';

    const ATTR_MIN_ROWS = 'min-rows';
    const ATTR_MAX_ROWS = 'max-rows';
    const ATTR_EXACT_ROWS = 'exact-rows';

    const ATTR_PREDEFINED_COLUMNS = 'predefined-columns';
    const ATTR_PREDEFINED_ROWS = 'predefined-rows';

    /**
     * @var string
     */
    protected $tableDataCellClass;

    /**
     * @var IField
     */
    protected $columnField;

    /**
     * @var IField|null
     */
    protected $rowField;

    /**
     * @var IField
     */
    protected $cellField;

    /**
     * TableType constructor
     *
     * @param string      $tableDataCellClass
     * @param IField      $columnField
     * @param IField|null $rowField
     * @param IField      $cellField
     */
    public function __construct($tableDataCellClass, IField $columnField, IField $rowField = null, IField $cellField)
    {
        $this->tableDataCellClass = $tableDataCellClass;
        $this->columnField = $columnField;
        $this->rowField = $rowField;
        $this->cellField = $cellField;

        parent::__construct($this->form());
    }

    /**
     * @return IField
     */
    public function getColumnField()
    {
        return $this->columnField;
    }

    /**
     * @return IField|null
     */
    public function getRowField()
    {
        return $this->rowField;
    }

    /**
     * @return IField
     */
    public function getCellField()
    {
        return $this->cellField;
    }

    /**
     * @return string
     */
    public function getTableDataCellClass()
    {
        return $this->tableDataCellClass;
    }

    /**
     * @inheritDoc
     */
    protected function initializeFromCurrentAttributes()
    {
        $this->attributes[self::ATTR_FORM] = $this->form();

        parent::initializeFromCurrentAttributes();
    }


    /**
     * @return IForm
     */
    protected function form()
    {
        $tableFields = [];

        $columnValidation = [
                ArrayOfType::ATTR_MIN_ELEMENTS   => $this->get(self::ATTR_MIN_COLUMNS),
                ArrayOfType::ATTR_MAX_ELEMENTS   => $this->get(self::ATTR_MAX_COLUMNS),
                ArrayOfType::ATTR_EXACT_ELEMENTS => $this->get(self::ATTR_EXACT_COLUMNS),
        ];

        $rowValidation = [
                ArrayOfType::ATTR_MIN_ELEMENTS   => $this->get(self::ATTR_MIN_ROWS),
                ArrayOfType::ATTR_MAX_ELEMENTS   => $this->get(self::ATTR_MAX_ROWS),
                ArrayOfType::ATTR_EXACT_ELEMENTS => $this->get(self::ATTR_EXACT_ROWS),
        ];

        $columnArrayField = Field::name(self::COLUMNS_FIELD)->label('Columns')
                ->arrayOfField($this->columnField)
                ->required()
                ->containsNoDuplicates()
                ->attrs($columnValidation);

        if ($this->has(self::ATTR_PREDEFINED_COLUMNS)) {
            $columnArrayField
                    ->value($this->get(self::ATTR_PREDEFINED_COLUMNS))
                    ->readonly();
        }

        $tableFields[] = $columnArrayField->build();


        if ($this->rowField) {
            $rowArrayField = Field::name(self::ROWS_FIELD)->label('Rows')
                    ->arrayOfField($this->rowField)
                    ->required()
                    ->containsNoDuplicates()
                    ->attrs($rowValidation);

            if ($this->has(self::ATTR_PREDEFINED_ROWS)) {
                $rowArrayField
                        ->value($this->get(self::ATTR_PREDEFINED_ROWS))
                        ->readonly();
            }

            $tableFields[] = $rowArrayField->build();
        }
        $tableFields[] = Field::name(self::CELLS_FIELD)->label('Cells')
                ->arrayOf(
                        Field::element()
                                ->arrayOfField($this->cellField)
                                ->required()
                                ->attrs($columnValidation)
                )
                ->required()
                ->attrs($rowValidation)
                ->build();

        return Form::create()
                ->section('Table', $tableFields)
                ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new TableStructureValidator(Type::arrayOf(Type::arrayOf(Type::mixed()))),
                new TableDataProcessor($this->tableDataCellClass),
        ]);
    }
}