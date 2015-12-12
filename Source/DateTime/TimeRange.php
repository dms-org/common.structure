<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

/**
 * The time range value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRange extends DateOrTimeRangeObject
{
    /**
     * @var Time
     */
    protected $start;

    /**
     * @var Time
     */
    protected $end;

    /**
     * TimeRange constructor.
     *
     * @param Time $start
     * @param Time $end
     */
    public function __construct(Time $start, Time $end)
    {
        parent::__construct($start, $end);
    }

    /**
     * @inheritDoc
     */
    protected function rangeOfClass()
    {
        return Time::class;
    }

    /**
     * Gets the start time of the range.
     *
     * @return Time
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Gets the end time of the range.
     *
     * @return Time
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns whether the supplied time is within (inclusive) the time range.
     *
     * @param Time $time
     *
     * @return bool
     */
    public function contains(Time $time)
    {
        return $this->start->isEarlierThanOrEqual($time) && $this->end->isLaterThanOrEqual($time);
    }

    /**
     * Returns whether the supplied time is within (exclusive) the time range.
     *
     * @param Time $time
     *
     * @return bool
     */
    public function containsExclusive(Time $time)
    {
        return $this->start->isEarlierThan($time) && $this->end->isLaterThan($time);
    }

    /**
     * Returns whether the supplied time range overlaps this time range.
     *
     * @param TimeRange $otherRange
     *
     * @return bool
     */
    public function overlaps(TimeRange $otherRange)
    {
        return $this->contains($otherRange->getStart()) || $this->contains($otherRange->getEnd());
    }
}