<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EntityWithDateTime extends Entity
{
    /**
     * @var DateTime
     */
    public $datetime;

    /**
     * @inheritDoc
     */
    public function __construct($id = null, DateTime $datetime)
    {
        parent::__construct($id);
        $this->datetime = $datetime;
    }


    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        $class->property($this->datetime)->asObject(DateTime::class);
    }
}