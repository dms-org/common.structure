<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

use Dms\Core\Exception\InvalidArgumentException;

/**
 * The time value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDay extends DateOrTimeObject
{
    const DEFAULT_FORMAT = 'g:i:s A';

    use TimeOfDayOperations;

    /**
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @throws InvalidArgumentException
     */
    public function __construct(int $hour, int $minute = 0, int $second = 0)
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
    public static function fromNative(\DateTimeInterface $dateTime) : TimeOfDay
    {
        return new self((int)$dateTime->format('H'), (int)$dateTime->format('i'), (int)$dateTime->format('s'));
    }

    /**
     * Creates a time object from the supplied format string
     *
     * @param string $format
     * @param string $timeString
     *
     * @return TimeOfDay
     */
    public static function fromFormat(string $format, string $timeString) : TimeOfDay
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
    public static function fromString(string $timeString) : TimeOfDay
    {
        $parts = array_map('intval', explode(':', $timeString)) + [1 => 0, 2 => 0];
        return new self($parts[0], $parts[1], $parts[2]);
    }

    /**
     * @inheritDoc
     */
    public function debugFormat() : string
    {
        return $this->dateTime->format(self::DEFAULT_FORMAT);
    }

    /**
     * @inheritDoc
     */
    protected function serializationFormat() : string
    {
        return self::DEFAULT_FORMAT;
    }

    /**
     * @inheritDoc
     */
    protected function getValidDateFormatChars() : array
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
    public function isLaterThan(TimeOfDay $other) : bool
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
    public function isLaterThanOrEqual(TimeOfDay $other) : bool
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
    public function isEarlierThan(TimeOfDay $other) : bool
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
    public function isEarlierThanOrEqual(TimeOfDay $other) : bool
    {
        return $this->dateTime <= $other->dateTime;
    }

    /**
     * Returns whether the time is AM
     *
     * @return bool
     */
    public function isAM() : bool
    {
        return $this->format('A') === 'AM';
    }

    /**
     * Returns whether the time is PM
     *
     * @return bool
     */
    public function isPM() : bool
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
    public function secondsBetween(TimeOfDay $other) : int
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
    public function equals(TimeOfDay $other) : bool
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