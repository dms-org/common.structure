<?php

namespace Dms\Common\Structure\Table;

/**
 * The table data column class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableDataColumn
{
    /**
     * @var mixed
     */
    protected $columnKey;

    /**
     * @var string
     */
    protected $label;

    /**
     * TableDataColumn constructor.
     *
     * @param mixed  $columnKey
     * @param string $label
     */
    public function __construct($columnKey, $label)
    {
        $this->columnKey = $columnKey;
        $this->label     = $label;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->columnKey;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}