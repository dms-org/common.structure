<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table\Form;

use Dms\Common\Structure\Table\Form\Processor\TableDataProcessor;
use Dms\Common\Structure\Table\Form\Processor\TableStructureValidator;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Type\ArrayOfType;
use Dms\Core\Form\Field\Type\FieldType;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IField;
use Dms\Core\Form\IForm;
use Dms\Core\Model\Type\Builder\Type;

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
    public function __construct(string $tableDataCellClass, IField $columnField, IField $rowField = null, IField $cellField)
    {
        $this->tableDataCellClass = $tableDataCellClass;
        $this->columnField        = $columnField;
        $this->rowField           = $rowField;
        $this->cellField          = $cellField;

        parent::__construct($this->form());
    }

    /**
     * @return IField
     */
    public function getColumnField() : IField
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
    public function getCellField() : IField
    {
        return $this->cellField;
    }

    /**
     * @return string
     */
    public function getTableDataCellClass() : string
    {
        return $this->tableDataCellClass;
    }

    /**
     * @inheritDoc
     */
    protected function initializeFromCurrentAttributes()
    {
        $this->attributes[self::ATTR_FORM] = $this->form();

        FieldType::initializeFromCurrentAttributes();
    }

    /**
     * @return IForm
     */
    protected function form() : IForm
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


        foreach ([&$rowValidation, &$columnValidation] as &$validation) {
            if ($validation[ArrayOfType::ATTR_EXACT_ELEMENTS] ?? $validation[ArrayOfType::ATTR_MIN_ELEMENTS] ?? false) {
                $validation[ArrayOfType::ATTR_FILL_KEYS_WITH_NULLS] = range(
                    0,
                    ($validation[ArrayOfType::ATTR_EXACT_ELEMENTS] ?? $validation[ArrayOfType::ATTR_MIN_ELEMENTS]) - 1
                );
            }
        }
        unset($validation);

        if ($this->has(self::ATTR_PREDEFINED_COLUMNS)) {
            $columnValidation[ArrayOfType::ATTR_EXACT_ELEMENTS]       = count($this->get(self::ATTR_PREDEFINED_COLUMNS));
            $columnValidation[ArrayOfType::ATTR_FILL_KEYS_WITH_NULLS] = array_keys($this->get(self::ATTR_PREDEFINED_COLUMNS));
        }

        if ($this->has(self::ATTR_PREDEFINED_ROWS)) {
            $rowValidation[ArrayOfType::ATTR_EXACT_ELEMENTS]       = count($this->get(self::ATTR_PREDEFINED_ROWS));
            $rowValidation[ArrayOfType::ATTR_FILL_KEYS_WITH_NULLS] = array_keys($this->get(self::ATTR_PREDEFINED_ROWS));
        }

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
    protected function buildProcessors() : array
    {
        return array_merge(parent::buildProcessors(), [
            new TableStructureValidator(Type::arrayOf(Type::arrayOf(Type::mixed()))),
            new TableDataProcessor($this->tableDataCellClass, $this->rowField !== null),
        ]);
    }
}