<?php

namespace Dms\Common\Structure\Tests\Table\Form\Processor;

use Dms\Common\Structure\Table\Form\Processor\TableDataProcessor;
use Dms\Common\Structure\Tests\Table\Fixtures\TestStringDataCell;
use Dms\Core\Form\IFieldProcessor;
use Dms\Core\Model\Type\IType;
use Dms\Core\Tests\Form\Field\Processor\FieldProcessorTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableDataProcessorTest extends FieldProcessorTest
{

    /**
     * @return IFieldProcessor
     */
    protected function processor()
    {
        return new TableDataProcessor(TestStringDataCell::class);
    }

    /**
     * @return IType
     */
    protected function processedType()
    {
        return TestStringDataCell::collectionType()->nullable();
    }

    /**
     * @return array[]
     */
    public function processTests()
    {
        return [
                [
                        ['columns' => [], 'rows' => [], 'cells' => []],
                        TestStringDataCell::collection([])
                ],
                [
                        [
                                'columns' => ['col'],
                                'rows'    => ['row'],
                                'cells'   => [
                                        ['cell']
                                ],
                        ],
                        TestStringDataCell::collection([
                                new TestStringDataCell('col', 'row', 'cell'),
                        ])
                ],
                [
                        [
                                'columns' => ['col:1', 'col:2', 'col:3'],
                                'rows'    => ['row:1', 'row:2'],
                                'cells'   => [
                                        ['a', 'b', 'c'],
                                        ['a', 'b', 'c'],
                                ],
                        ],
                        TestStringDataCell::collection([
                                new TestStringDataCell('col:1', 'row:1', 'a'),
                                new TestStringDataCell('col:1', 'row:2', 'a'),
                                //
                                new TestStringDataCell('col:2', 'row:1', 'b'),
                                new TestStringDataCell('col:2', 'row:2', 'b'),
                                //
                                new TestStringDataCell('col:3', 'row:1', 'c'),
                                new TestStringDataCell('col:3', 'row:2', 'c'),
                        ])
                ],
                [
                        [
                                'columns' => ['col:1' => 'col:1', 'col:2' => 'col:2', 'col:3' => 'col:3'],
                                'rows'    => ['row:1' => 'row:1', 'row:2' => 'row:2'],
                                'cells'   => [
                                        'row:1' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                        'row:2' => ['col:1' => 'a', 'col:2' => 'b', 'col:3' => 'c'],
                                ],
                        ],
                        TestStringDataCell::collection([
                                new TestStringDataCell('col:1', 'row:1', 'a'),
                                new TestStringDataCell('col:1', 'row:2', 'a'),
                                //
                                new TestStringDataCell('col:2', 'row:1', 'b'),
                                new TestStringDataCell('col:2', 'row:2', 'b'),
                                //
                                new TestStringDataCell('col:3', 'row:1', 'c'),
                                new TestStringDataCell('col:3', 'row:2', 'c'),
                        ])
                ],
        ];
    }

    /**
     * @return array[]
     */
    public function unprocessTests()
    {
        $reverseProcessTests = [];

        foreach ($this->processTests() as list($unprocessed, $processed)) {
            // Unprocessed data uses 0-based incrementing integers as keys.
            $unprocessed          = array_map('array_values', $unprocessed);
            $unprocessed['cells'] = array_map('array_values', $unprocessed['cells']);

            $reverseProcessTests[] = [$processed, $unprocessed];
        }

        return $reverseProcessTests;
    }
}