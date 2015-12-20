<?php

namespace Dms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Dms\Common\Structure\Table\TableData;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursEntity extends Entity
{
    /**
     * @var TableData|TestBusinessHoursTimetableCell[]
     */
    public $timetable;

    /**
     * @inheritDoc
     */
    public function __construct($id, TableData $timetable)
    {
        parent::__construct($id);
        $this->timetable = $timetable;
    }

    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        $class->property($this->timetable)->asType(TestBusinessHoursTimetableCell::collectionType());
    }
}