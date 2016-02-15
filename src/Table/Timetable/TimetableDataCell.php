<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Table\Timetable;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Table\TableDataCell;
use Dms\Core\Model\Object\ClassDefinition;

/**
 * The timetable data value object base class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class TimetableDataCell extends TableDataCell
{
    /**
     * @var DayOfWeek
     */
    public $columnKey;

    /**
     * @var TimeOfDay
     */
    public $rowKey;

    /**
     * TimetableDataCell constructor.
     *
     * @param DayOfWeek $columnKey
     * @param TimeOfDay $rowKey
     * @param mixed     $cellValue
     */
    public function __construct(DayOfWeek $columnKey, TimeOfDay $rowKey, $cellValue)
    {
        parent::__construct($columnKey, $rowKey, $cellValue);
    }

    /**
     * @inheritDoc
     */
    final protected function define(ClassDefinition $class)
    {
        $class->property($this->columnKey)->asObject(DayOfWeek::class);

        $class->property($this->rowKey)->asObject(TimeOfDay::class);

        $this->defineCell($class);
    }

    /**
     * Defines the structure of this cell class.
     *
     * @param ClassDefinition $class
     *
     * @return void
     */
    abstract protected function defineCell(ClassDefinition $class);

    /**
     * @inheritDoc
     */
    public function getColumnLabel() : string
    {
        return $this->columnKey->getShortName();
    }

    /**
     * @inheritDoc
     */
    public function getRowLabel() : string
    {
        return $this->rowKey->format('g:i A');
    }
}