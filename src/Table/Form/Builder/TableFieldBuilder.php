<?php

namespace Dms\Common\Structure\Table\Form\Builder;

use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Common\Structure\Table\Form\TableType;

/**
 * The table field builder class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TableFieldBuilder extends FieldBuilderBase
{
    /**
     * TableFieldBuilder constructor.
     *
     * @param FieldBuilderBase $previous
     */
    public function __construct(FieldBuilderBase $previous)
    {
        parent::__construct($previous);
    }

    /**
     * Sets the minimum number of columns in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function minColumns($amount)
    {
        return $this->attr(TableType::ATTR_MIN_COLUMNS, $amount);
    }

    /**
     * Sets the maximum number of columns in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function maxColumns($amount)
    {
        return $this->attr(TableType::ATTR_MAX_COLUMNS, $amount);
    }

    /**
     * Sets the exact number of columns in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function exactColumns($amount)
    {
        return $this->attr(TableType::ATTR_EXACT_COLUMNS, $amount);
    }

    /**
     * Sets the minimum number of rows in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function minRows($amount)
    {
        return $this->attr(TableType::ATTR_MIN_ROWS, $amount);
    }

    /**
     * Sets the maximum number of rows in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function maxRows($amount)
    {
        return $this->attr(TableType::ATTR_MAX_ROWS, $amount);
    }

    /**
     * Sets the exact number of rows in the table.
     *
     * @param int $amount
     *
     * @return static
     */
    public function exactRows($amount)
    {
        return $this->attr(TableType::ATTR_EXACT_ROWS, $amount);
    }
}