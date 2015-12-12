<?php

namespace Iddigital\Cms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject;

use Iddigital\Cms\Common\Structure\DateTime\Persistence\DateTimeMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\EntityMapper;

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