<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableData;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\Entity;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursEntity extends Entity
{
    /**
     * @var TestBusinessHoursTimetableData
     */
    public $timetable;

    /**
     * @inheritDoc
     */
    public function __construct($id, TestBusinessHoursTimetableData $timetable)
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
        $class->property($this->timetable)->asObject(TestBusinessHoursTimetableData::class);
    }
}