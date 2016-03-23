<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

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
    protected function rangeOfClass() : string
    {
        return Date::class;
    }

    /**
     * Gets the start date of the range.
     *
     * @return Date
     */
    public function getStart() : Date
    {
        return $this->start;
    }

    /**
     * Gets the end date of the range.
     *
     * @return Date
     */
    public function getEnd() : Date
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
    public function contains(Date $date) : bool
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
    public function containsExclusive(Date $date) : bool
    {
        return $this->start->comesBefore($date) && $this->end->comesAfter($date);
    }

    /**
     * Returns whether the supplied date range is encompassed by this
     * date range.
     *
     * @param DateRange $otherRange
     *
     * @return bool
     */
    public function encompasses(DateRange $otherRange) : bool
    {
        return $this->start->comesBeforeOrEqual($otherRange->start) && $this->end->comesAfterOrEqual($otherRange->end);
    }

    /**
     * Returns whether the supplied date range overlaps this date range.
     *
     * @param DateRange $otherRange
     *
     * @return bool
     */
    public function overlaps(DateRange $otherRange) : bool
    {
        return $this->contains($otherRange->start) || $this->contains($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }

    /**
     * Returns whether the supplied date range overlaps (exclusive) this date range.
     *
     * @param DateRange $otherRange
     *
     * @return bool
     */
    public function overlapsExclusive(DateRange $otherRange) : bool
    {
        return $this->containsExclusive($otherRange->start) || $this->containsExclusive($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }
}