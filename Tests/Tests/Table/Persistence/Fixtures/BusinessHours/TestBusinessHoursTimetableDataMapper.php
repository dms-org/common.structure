<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours;

use Iddigital\Cms\Common\Structure\Table\Persistence\TimetableDataMapper;
use Iddigital\Cms\Common\Structure\Table\TableDataCell;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableData;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessHoursTimetableDataMapper extends TimetableDataMapper
{

    /**
     * @return string
     */
    protected function tableDataClass()
    {
        return TestBusinessHoursTimetableData::class;
    }

    /**
     * The table name to which the data is saved to.
     *
     * @return string
     */
    protected function tableName()
    {
        return 'business_hours_data';
    }

    /**
     * The name of the foreign key to the parent table.
     *
     * @return string
     */
    protected function foreignKeyName()
    {
        return 'business_hours_id';
    }

    /**
     * Defines the value object mapper for the cells contained within the table.
     *
     * @see TableDataCell
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function defineCellDataMapper(MapperDefinition $map)
    {
        $map->relation(TableDataCell::CELL_VALUE)
                ->asEmbedded()
                ->enum(TestBusinessAvailability::class)
                ->to('status')
                ->usingValuesFromConstants();
    }
}