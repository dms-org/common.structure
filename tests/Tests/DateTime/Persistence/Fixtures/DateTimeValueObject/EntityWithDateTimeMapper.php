<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject;

use Dms\Common\Structure\DateTime\Persistence\DateTimeMapper;
use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\EntityMapper;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EntityWithDateTimeMapper extends EntityMapper
{
    /**
     * Defines the entity mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(EntityWithDateTime::class);
        $map->toTable('entities');

        $map->idToPrimaryKey('id');

        $map->embedded('datetime')->using(new DateTimeMapper('datetime'));
    }
}