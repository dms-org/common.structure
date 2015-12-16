<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * The time value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDay extends DateOrTimeObject
{
    use TimeOfDayOperations;

    /**
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @throws InvalidArgumentException
     */
    public function __construct($hour, $minute = 0, $second = 0)
    {
        $dateTime = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
                ->setDate(1970, 1, 1)
                ->setTime($hour, $minute, $second);

        if ($dateTime->getTimestamp() > 24 * 60 * 60) {
            throw InvalidArgumentException::format(
                    'Invalid time supplied to %s: time must add up to less than 24 hours, %s given (%s seconds)',
                    __METHOD__, $hour, $minute, $second, $dateTime->getTimestamp()
            );
        }

        parent::__construct($dateTime);
    }

    /**
     * Creates a time object from the time part of the supplied date time.
     *
     * @param \DateTimeInterface $dateTime
     *
     * @return TimeOfDay
     */
    public static function fromNative(\DateTimeInterface $dateTime)
    {
        return new self($dateTime->format('H'), $dateTime->format('i'), $dateTime->format('s'));
    }

    /**
     * Creates a time object from the supplied format string
     *
     * @param string $format
     * @param string $timeString
     *
     * @return TimeOfDay
     */
    public static function fromFormat($format, $timeString)
    {
        return self::fromNative(\DateTimeImmutable::createFromFormat($format, $timeString));
    }

    /**
     * Creates a time object from the supplied 24 hour time string
     *
     * Expected format: HH[:MM[:SS]]
     *
     * @param string $timeString
     *
     * @return TimeOfDay
     */
    public static function fromString($timeString)
    {
        $parts = array_map('intval', explode(':', $timeString)) + [1 => 0, 2 => 0];
        return new self($parts[0], $parts[1], $parts[2]);
    }

    /**
     * @inheritDoc
     */
    public function debugFormat()
    {
        return $this->dateTime->format('H:i:s');
    }

    /**
     * @inheritDoc
     */
    protected function serializationFormat()
    {
        return 'H:i:s';
    }

    /**
     * @inheritDoc
     */
    protected function getValidDateFormatChars()
    {
        return ['a', 'A', 'B', 'g', 'G', 'h', 'H', 'i', 's'];
    }

    /**
     * Returns whether the time is greater than the supplied time.
     *
     * @param TimeOfDay $other
     *
     * @return bool
     */
    public function isLaterThan(TimeOfDay $other)
    {
        return $this->dateTime > $other->dateTime;
    }

    /**
     * Returns whether the time is greater than the supplied time.
     *
     * @param TimeOfDay $other
     *
     * @return bool
     */
    public function isLaterThanOrEqual(TimeOfDay $other)
    {
        return $this->dateTime >= $other->dateTime;
    }

    /**
     * Returns whether the time is less than the supplied time.
     *
     * @param TimeOfDay $other
     *
     * @return bool
     */
    public function isEarlierThan(TimeOfDay $other)
    {
        return $this->dateTime < $other->dateTime;
    }

    /**
     * Returns whether the time is less than the supplied time.
     *
     * @param TimeOfDay $other
     *
     * @return bool
     */
    public function isEarlierThanOrEqual(TimeOfDay $other)
    {
        return $this->dateTime <= $other->dateTime;
    }

    /**
     * Returns whether the time is AM
     *
     * @return bool
     */
    public function isAM()
    {
        return $this->format('A') === 'AM';
    }

    /**
     * Returns whether the time is PM
     *
     * @return bool
     */
    public function isPM()
    {
        return $this->format('A') === 'PM';
    }

    /**
     * Returns the amount of seconds between the supplied times.
     *
     * @param TimeOfDay $other
     *
     * @return int
     */
    public function secondsBetween(TimeOfDay $other)
    {
        return abs($this->dateTime->getTimestamp() - $other->dateTime->getTimestamp());
    }

    /**
     * Returns whether the time is equal to the supplied time.
     *
     * @param TimeOfDay $other
     *
     * @return bool
     */
    public function equals(TimeOfDay $other)
    {
        return $this->dateTime == $other->dateTime;
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return static
     */
    protected function createFromNativeObject(\DateTimeInterface $dateTime)
    {
        return self::fromNative($dateTime);
    }
}