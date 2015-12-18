<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Iddigital\Cms\Common\Structure\DateTime\Persistence\TimeOfDayMapper;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
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

        $map->embeddedCollection('timetable')
                ->toTable('business_hours_data')
                ->withPrimaryKey('id')
                ->withForeignKeyToParentAs('business_hours_id')
                ->usingCustom(function (MapperDefinition $map) {
                    $map->type(TestBusinessHoursTimetableCell::class);

                    $map->enum(TestBusinessHoursTimetableCell::COLUMN_KEY)
                            ->to('day')
                            ->usingValuesFromConstants();

                    $map->embedded(TestBusinessHoursTimetableCell::ROW_KEY)
                            ->using(new TimeOfDayMapper('time'));

                    $map->enum(TestBusinessHoursTimetableCell::CELL_VALUE)
                            ->to('status')
                            ->usingValuesFromConstants();
                });
    }
}