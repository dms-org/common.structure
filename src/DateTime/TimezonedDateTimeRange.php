<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

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
    protected function rangeOfClass() : string
    {
        return TimezonedDateTime::class;
    }

    /**
     * Gets the start timezoned date time of the range.
     *
     * @return TimezonedDateTime
     */
    public function getStart() : TimezonedDateTime
    {
        return $this->start;
    }

    /**
     * Gets the end timezoned date time of the range.
     *
     * @return TimezonedDateTime
     */
    public function getEnd() : TimezonedDateTime
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
    public function contains(TimezonedDateTime $timezonedDateTime) : bool
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
    public function containsExclusive(TimezonedDateTime $timezonedDateTime) : bool
    {
        return $this->start->comesBefore($timezonedDateTime) && $this->end->comesAfter($timezonedDateTime);
    }

    /**
     * Returns whether the supplied timezoned date time range is encompassed by this
     * timezoned date time range.
     *
     * @param TimezonedDateTimeRange $otherRange
     *
     * @return bool
     */
    public function encompasses(TimezonedDateTimeRange $otherRange) : bool
    {
        return $this->start->comesBeforeOrEqual($otherRange->start) && $this->end->comesAfterOrEqual($otherRange->end);
    }

    /**
     * Returns whether the supplied timezoned date time range overlaps this date time range.
     *
     * @param TimezonedDateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlaps(TimezonedDateTimeRange $otherRange) : bool
    {
        return $this->contains($otherRange->start) || $this->contains($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }

    /**
     * Returns whether the supplied timezoned date time range overlaps (exclusive) this date time range.
     *
     * @param TimezonedDateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlapsExclusive(TimezonedDateTimeRange $otherRange) : bool
    {
        return $this->containsExclusive($otherRange->start) || $this->containsExclusive($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }
}