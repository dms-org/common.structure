<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject;

use Iddigital\Cms\Common\Structure\DateTime\DateTime;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\Entity;

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