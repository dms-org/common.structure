<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableData;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\EntityMapper;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursEntityMapper extends EntityMapper
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
        $map->type(TestBusinessHoursEntity::class);
        $map->toTable('business_hours');

        $map->idToPrimaryKey('id');

        $map->embedded('timetable')->to(TestBusinessHoursTimetableData::class);
    }
}