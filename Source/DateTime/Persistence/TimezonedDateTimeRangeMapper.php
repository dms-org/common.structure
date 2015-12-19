<?php

namespace Iddigital\Cms\Common\Structure\DateTime\Persistence;

use Iddigital\Cms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Iddigital\Cms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;

/**
 * The timezoned date time range value object mapper
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeMapper extends DateOrTimeRangeMapper
{
    /**
     * @var string
     */
    protected $startTimezoneName;

    /**
     * @var string
     */
    protected $endTimezoneName;

    /**
     * TimezonedDateTimeRangeMapper constructor.
     *
     * @param string $startDateTimeColumnName
     * @param string $startTimezoneName
     * @param string $endDateTimeColumnName
     * @param string $endTimezoneName
     */
    public function __construct(
            $startDateTimeColumnName = 'start_datetime',
            $startTimezoneName = 'start_timezone',
            $endDateTimeColumnName = 'end_datetime',
            $endTimezoneName = 'end_timezone'
    )
    {
        $this->startTimezoneName = $startTimezoneName;
        $this->endTimezoneName   = $endTimezoneName;
        parent::__construct($startDateTimeColumnName, $endDateTimeColumnName);
    }

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(TimezonedDateTimeRange::class);

        $map->embedded(TimezonedDateTimeRange::START)
                ->using(new TimezonedDateTimeMapper($this->startColumnName, $this->startTimezoneName));

        $map->embedded(TimezonedDateTimeRange::END)
                ->using(new TimezonedDateTimeMapper($this->endColumnName, $this->endTimezoneName));
    }
}