<?php

namespace Dms\Common\Structure\Table;

/**
 * The row tuple class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Row
{
    /**
     * @var mixed
     */
    protected $rowKey;

    /**
     * @var array
     */
    protected $cellValues = [];

    /**
     * Row constructor.
     *
     * @param mixed $rowKey
     * @param array $cellValues
     */
    public function __construct($rowKey, array $cellValues)
    {
        $this->rowKey     = $rowKey;
        $this->cellValues = $cellValues;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->rowKey;
    }

    /**
     * @return array
     */
    public function getCellValues()
    {
        return $this->cellValues;
    }
}