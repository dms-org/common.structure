<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

/**
 * The timezoned date time range value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRange extends DateOrTimeRangeObject
{
    /**
     * @var TimezonedDateTime
     */
    protected $start;

    /**
     * @var TimezonedDateTime
     */
    protected $end;

    /**
     * TimezonedDateTimeRange constructor.
     *
     * @param TimezonedDateTime $start
     * @param TimezonedDateTime $end
     */
    public function __construct(TimezonedDateTime $start, TimezonedDateTime $end)
    {
        parent::__construct($start, $end);
    }

    /**
     * @inheritDoc
     */
    protected function rangeOfClass()
    {
        return TimezonedDateTime::class;
    }

    /**
     * Gets the start timezoned date time of the range.
     *
     * @return TimezonedDateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Gets the end timezoned date time of the range.
     *
     * @return TimezonedDateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns whether the supplied timezoned date time is within (inclusive) the date time range.
     *
     * @param TimezonedDateTime $timezonedDateTime
     *
     * @return bool
     */
    public function contains(TimezonedDateTime $timezonedDateTime)
    {
        return $this->start->comesBeforeOrEqual($timezonedDateTime) && $this->end->comesAfterOrEqual($timezonedDateTime);
    }

    /**
     * Returns whether the supplied timezoned date time is within (exclusive) the date time range.
     *
     * @param TimezonedDateTime $timezonedDateTime
     *
     * @return bool
     */
    public function containsExclusive(TimezonedDateTime $timezonedDateTime)
    {
        return $this->start->comesBefore($timezonedDateTime) && $this->end->comesAfter($timezonedDateTime);
    }

    /**
     * Returns whether the supplied timezoned date time range overlaps this date time range.
     *
     * @param TimezonedDateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlaps(TimezonedDateTimeRange $otherRange)
    {
        return $this->contains($otherRange->getStart()) || $this->contains($otherRange->getEnd());
    }
}