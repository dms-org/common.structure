<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\Date;
use Iddigital\Cms\Common\Structure\DateTime\DateTime;
use Iddigital\Cms\Common\Structure\DateTime\DateTimeRange;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Common\Structure\DateTime\TimeRange;
use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTime;
use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Orm;

/**
 * The date time orm.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeOrm extends Orm
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
        $orm->valueObjects([
                TimeOfDay::class              => TimeOfDayMapper::class,
                Date::class                   => DateMapper::class,
                DateTime::class               => DateTimeMapper::class,
                TimezonedDateTime::class      => TimeZonedDateTimeMapper::class,
                //
                TimeRange::class              => TimeRangeMapper::class,
                DateRangeMapper::class        => DateRangeMapper::class,
                DateTimeRange::class          => DateTimeRangeMapper::class,
                TimezonedDateTimeRange::class => TimezonedDateTimeRangeMapper::class,
        ]);
    }
}