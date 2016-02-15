<?php

namespace Dms\Common\Structure\Tests\Table\Fixtures;

use Dms\Common\Structure\Table\TableDataCell;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestStringDataCell extends TableDataCell
{
    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->columnKey)->asString();
        $class->property($this->rowKey)->asString();
        $class->property($this->cellValue)->asString();
    }

    /**
     * Gets the label for the column of this cell.
     *
     * @return string
     */
    public function getColumnLabel() : string
    {
        return $this->columnKey;
    }

    /**
     * Gets the label for the row of this cell.
     *
     * @return string
     */
    public function getRowLabel() : string
    {
        return $this->rowKey;
    }
}