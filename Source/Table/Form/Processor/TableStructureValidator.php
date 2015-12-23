<?php

namespace Dms\Common\Structure\Table\Form\Processor;

use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\IType;
use Dms\Common\Structure\Table\Form\TableType;

/**
 * The table structure validator.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableStructureValidator extends FieldValidator
{
    const MESSAGE_INVALID_STRUCTURE = 'validation.table.invalid-structure';


    /**
     * TableStructureValidator constructor.
     *
     * @param IType    $inputType
     */
    public function __construct(IType $inputType)
    {
        parent::__construct($inputType);
    }

    /**
     * Validates the supplied input and adds an
     * error messages to the supplied array.
     *
     * @param mixed     $input
     * @param Message[] $messages
     */
    protected function validate($input, array &$messages)
    {
        $columns = $input[TableType::COLUMNS_FIELD];
        $rows    = isset($input[TableType::ROWS_FIELD]) ? $input[TableType::ROWS_FIELD] : null;
        $cells   = $input[TableType::CELLS_FIELD];

        if ($rows) {
            $amountOfRows = count($rows);

            if (count($cells) !== $amountOfRows) {
                $messages[] = new Message(self::MESSAGE_INVALID_STRUCTURE);
                return;
            }

            foreach ($rows as $rowKey => $rowKeyValue) {
                if (!isset($cells[$rowKey])) {
                    $messages[] = new Message(self::MESSAGE_INVALID_STRUCTURE);
                    return;
                }
            }
        }

        $amountOfColumns = count($columns);

        foreach ($cells as $index => $cellRow) {
            if (count($cellRow) !== $amountOfColumns) {
                $messages[] = new Message(self::MESSAGE_INVALID_STRUCTURE);
                return;
            }

            foreach ($columns as $columnKey => $columnKeyValue) {
                if (!isset($cellRow[$columnKey])) {
                    $messages[] = new Message(self::MESSAGE_INVALID_STRUCTURE);
                    return;
                }
            }
        }
    }
}