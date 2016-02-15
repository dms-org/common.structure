<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Persistence;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimeRange;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Persistence\Db\Mapping\Definition\Orm\OrmDefinition;
use Dms\Core\Persistence\Db\Mapping\Orm;

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
                TimezonedDateTime::class      => TimezonedDateTimeMapper::class,
                //
                TimeRange::class              => TimeRangeMapper::class,
                DateRangeMapper::class        => DateRangeMapper::class,
                DateTimeRange::class          => DateTimeRangeMapper::class,
                TimezonedDateTimeRange::class => TimezonedDateTimeRangeMapper::class,
        ]);
    }
}