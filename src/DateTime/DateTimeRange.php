<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

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
    protected function rangeOfClass() : string
    {
        return DateTime::class;
    }

    /**
     * Gets the start dateTime of the range.
     *
     * @return DateTime
     */
    public function getStart() : DateTime
    {
        return $this->start;
    }

    /**
     * Gets the end dateTime of the range.
     *
     * @return DateTime
     */
    public function getEnd() : DateTime
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
    public function contains(DateTime $dateTime) : bool
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
    public function containsExclusive(DateTime $dateTime) : bool
    {
        return $this->start->comesBefore($dateTime) && $this->end->comesAfter($dateTime);
    }

    /**
     * Returns whether the supplied date time range is encompassed by this
     * date time range.
     *
     * @param DateTimeRange $otherRange
     *
     * @return bool
     */
    public function encompasses(DateTimeRange $otherRange) : bool
    {
        return $this->start->comesBeforeOrEqual($otherRange->start) && $this->end->comesAfterOrEqual($otherRange->end);
    }

    /**
     * Returns whether the supplied date time range overlaps this date time range.
     *
     * @param DateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlaps(DateTimeRange $otherRange) : bool
    {
        return $this->contains($otherRange->start) || $this->contains($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }

    /**
     * Returns whether the supplied date time range overlaps (exclusive) this date time range.
     *
     * @param DateTimeRange $otherRange
     *
     * @return bool
     */
    public function overlapsExclusive(DateTimeRange $otherRange) : bool
    {
        return $this->containsExclusive($otherRange->start) || $this->containsExclusive($otherRange->end)
        || $this->encompasses($otherRange)
        || $otherRange->encompasses($this);
    }
}