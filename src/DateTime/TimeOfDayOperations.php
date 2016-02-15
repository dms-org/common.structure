<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

/**
 * The time operations trait.
 *
 * @property \DateTimeImmutable dateTime
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
trait TimeOfDayOperations
{
    /**
     * Gets the hour
     *
     * @return int
     */
    public function getHour() : int
    {
        return (int)$this->dateTime->format('H');
    }

    /**
     * Gets the minute
     *
     * @return int
     */
    public function getMinute() : int
    {
        return (int)$this->dateTime->format('i');
    }

    /**
     * Gets the second
     *
     * @return int
     */
    public function getSecond() : int
    {
        return (int)$this->dateTime->format('s');
    }

    /**
     * Returns whether the time is after 12:00:00 PM
     *
     * @return bool
     */
    public function afterNoon() : bool
    {
        return $this->getHour() >= 12 && !$this->isNoon();
    }

    /**
     * Returns whether the time is before 12:00:00 PM
     *
     * @return bool
     */
    public function isNoon() : bool
    {
        return $this->getHour() === 12 && $this->getMinute() === 0 && $this->getSecond() === 0;
    }

    /**
     * Returns whether the time is before 11:59:59 AM
     *
     * @return bool
     */
    public function beforeNoon() : bool
    {
        return $this->getHour() < 12;
    }

    /**
     * Returns a new time with the supplied amount of seconds added.
     *
     * @param int $seconds
     *
     * @return static
     */
    public function addSeconds(int $seconds)
    {
        return $this->add(\DateInterval::createFromDateString($seconds . ' seconds'));
    }

    /**
     * Returns a new time with the supplied amount of seconds subtracted.
     *
     * @param int $seconds
     *
     * @return static
     */
    public function subSeconds(int $seconds)
    {
        return $this->addSeconds(-$seconds);
    }

    /**
     * Returns a new time with the supplied amount of minutes added.
     *
     * @param int $minutes
     *
     * @return static
     */
    public function addMinutes(int $minutes)
    {
        return $this->add(\DateInterval::createFromDateString($minutes . ' minutes'));
    }

    /**
     * Returns a new time with the supplied amount of minutes subtracted.
     *
     * @param int $minutes
     *
     * @return static
     */
    public function subMinutes(int $minutes)
    {
        return $this->addMinutes(-$minutes);
    }

    /**
     * Returns a new time with the supplied amount of hours added.
     *
     * @param int $hours
     *
     * @return static
     */
    public function addHours(int $hours)
    {
        return $this->add(\DateInterval::createFromDateString($hours . ' hours'));
    }

    /**
     * Returns a new time with the supplied amount of hours subtracted.
     *
     * @param int $hours
     *
     * @return static
     */
    public function subHours(int $hours)
    {
        return $this->addHours(-$hours);
    }

    /**
     * @param \DateInterval $interval
     *
     * @return static
     */
    abstract protected function add(\DateInterval $interval);
}