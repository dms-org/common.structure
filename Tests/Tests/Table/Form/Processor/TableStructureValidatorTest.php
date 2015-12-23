<?php

namespace Dms\Common\Structure\Tests\Table\Form\Processor;

use Dms\Common\Structure\Table\Form\Processor\TableStructureValidator;
use Dms\Core\Form\Field\Processor\FieldValidator;
use Dms\Core\Language\Message;
use Dms\Core\Model\Type\Builder\Type;
use Dms\Core\Model\Type\IType;
use Dms\Core\Tests\Form\Field\Processor\Validator\FieldValidatorTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableStructureValidatorTest extends FieldValidatorTest
{

    /**
     * @return FieldValidator
     */
    protected function validator()
    {
        return new TableStructureValidator(Type::arrayOf(Type::arrayOf(Type::mixed())));
    }

    /**
     * @return IType
     */
    protected function processedType()
    {
        return Type::arrayOf(Type::arrayOf(Type::mixed()));
    }

    /**
     * @return array[]
     */
    public function successTests()
    {
        return [
                [['columns' => [], 'rows' => [], 'cells' => []]],
                [
                        [
                                'columns' => [1],
                                'rows'    => [1],
                                'cells'   => [
                                        [1]
                                ],
                        ]
                ],
                [
                        [
                                'columns' => [1, 2, 3],
                                'rows'    => [1, 2],
                                'cells'   => [
                                        ['a', 'b', 'c'],
                                        ['a', 'b', 'c'],
                                ],
                        ]
                ],
                [
                        [
                                'columns' => ['col:1' => 1, 'col:2' => 2, 'col:3' => 3],
                                'rows'    => ['row:1' => 1, 'row:2' => 2],
                                'cells'   => [
                                        'row:1' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                        'row:2' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                ],
                        ]
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function failTests()
    {
        return [
                [
                        [
                                'columns' => [1],
                                'rows'    => [1],
                                'cells'   => [
                                        []
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
                [
                        [
                                'columns' => [1, 2, 3],
                                'rows'    => [1, 2, 3],
                                'cells'   => [
                                        ['a', 'b', 'c'],
                                        ['a', 'b', 'c'],
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
                [
                        [
                                'columns' => [1, 2, 3],
                                'rows'    => [1, 2, 3],
                                'cells'   => [
                                        ['a', 'b'],
                                        ['a', 'b', 'c'],
                                        ['a', 'b', 'c'],
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
                [
                        [
                                'columns' => [1, 2, 3],
                                'rows'    => [1, 2, 3],
                                'cells'   => [
                                        ['a'],
                                        ['a', 'b', 'c'],
                                        ['a', 'b', 'c'],
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
                [
                        [
                                'columns' => ['col:1' => 1, 'col:2' => 2, 'col:3' => 3],
                                'rows'    => ['row:1' => 1, 'row:2' => 2],
                                'cells'   => [
                                        'row:1' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                        'row:2' => ['!!!' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
                [
                        [
                                'columns' => ['col:1' => 1, 'col:2' => 2, 'col:3' => 3],
                                'rows'    => ['row:1' => 1, 'row:2' => 2],
                                'cells'   => [
                                        '!!!!'  => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                        'row:2' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                ],
                        ],
                        [new Message(TableStructureValidator::MESSAGE_INVALID_STRUCTURE)]
                ],
        ];
    }
}