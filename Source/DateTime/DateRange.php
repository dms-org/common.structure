<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

/**
 * The date range value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRange extends DateOrTimeRangeObject
{
    /**
     * @var Date
     */
    protected $start;

    /**
     * @var Date
     */
    protected $end;

    /**
     * DateRange constructor.
     *
     * @param Date $start
     * @param Date $end
     */
    public function __construct(Date $start, Date $end)
    {
        parent::__construct($start, $end);
    }

    /**
     * @inheritDoc
     */
    protected function rangeOfClass()
    {
        return Date::class;
    }

    /**
     * Gets the start date of the range.
     *
     * @return Date
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Gets the end date of the range.
     *
     * @return Date
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Returns whether the supplied date is within (inclusive) the date range.
     *
     * @param Date $date
     *
     * @return bool
     */
    public function contains(Date $date)
    {
        return $this->start->comesBeforeOrEqual($date) && $this->end->comesAfterOrEqual($date);
    }

    /**
     * Returns whether the supplied date is within (exclusive) the date range.
     *
     * @param Date $date
     *
     * @return bool
     */
    public function containsExclusive(Date $date)
    {
        return $this->start->comesBefore($date) && $this->end->comesAfter($date);
    }

    /**
     * Returns whether the supplied date range overlaps this date range.
     *
     * @param DateRange $otherRange
     *
     * @return bool
     */
    public function overlaps(DateRange $otherRange)
    {
        return $this->contains($otherRange->getStart()) || $this->contains($otherRange->getEnd());
    }
}