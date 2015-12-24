<?php

namespace Dms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursOrm extends Orm
{
    /**
     * Defines the object mappers registered in the orm.
     *
     * @param OrmDefinition $orm
     *
     * @return void
     */
    protected function define(OrmDefinition $orm)
    {
        $orm->entity(TestBusinessHoursEntity::class)
                ->from(TestBusinessHoursEntityMapper::class);
    }
}