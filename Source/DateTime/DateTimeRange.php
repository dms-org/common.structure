<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

/**
 * The date time range value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRange extends DateOrTimeRangeObject
{
    /**
     * @var DateTime
     */
    protected $start;

    /**
     * @var DateTime
     */
    protected $end;

    /**
     * DateTimeRange constructor.
     *
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(DateTime $start, DateTime $end)
    {
        parent::__construct($start, $end);
    }

    /**
     * @inheritDoc
     */
    protected function rangeOfClass()
    {
        return DateTime::class;
    }

    /**
     * Gets the start dateTime of the range.
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Gets the end dateTime of the range.
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns whether the supplied date time is within (inclusive) the date time range.
     *
     * @param DateTime $dateTime
     *
     * @return bool
     */
    public function contains(DateTime $dateTime)
    {
        return $this->start->comesBeforeOrEqual($dateTime) && $this->end->comesAfterOrEqual($dateTime);
    }

    /**
     * Returns whether the supplied date time is within (exclusive) the date time range.
     *
     * @param DateTime $dateTime
     *
     * @return bool
     */
    public function containsExclusive(DateTime $dateTime)
    {
        return $this->start->comesBefore($dateTime) && $this->end->comesAfter($dateTime);
    }

    /**
     * Returns whether the supplied date time range overlaps this date time range.
     *
     * @param DateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlaps(DateTimeRange $otherRange)
    {
        return $this->contains($otherRange->getStart()) || $this->contains($otherRange->getEnd());
    }
}