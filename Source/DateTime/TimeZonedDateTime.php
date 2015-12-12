<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

/**
 * The timezoned date time value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeZonedDateTime extends DateTimeBase
{
    /**
     * @param \DateTimeInterface $dateTime
     */
    public function __construct(\DateTimeInterface $dateTime)
    {
        parent::__construct(
                (new \DateTimeImmutable())
                        ->setTimestamp($dateTime->getTimestamp())
                        ->setTimezone($dateTime->getTimezone())
        );
    }

    /**
     * Creates a DateTime object from the supplied date string
     *
     * @param string $dateTimeString
     * @param string $timeZoneId
     *
     * @return TimeZonedDateTime
     */
    public static function fromString($dateTimeString, $timeZoneId)
    {
        return new self(new \DateTimeImmutable($dateTimeString, new \DateTimeZone($timeZoneId)));
    }

    /**
     * Creates a DateTime object from the supplied format string
     *
     * @param string $format
     * @param string $dateString
     * @param string $timeZoneId
     *
     * @return TimeZonedDateTime
     */
    public static function fromFormat($format, $dateString, $timeZoneId)
    {
        return new self(\DateTimeImmutable::createFromFormat('!' . $format, $dateString, new \DateTimeZone($timeZoneId)));
    }

    /**
     * @inheritDoc
     */
    public function debugFormat()
    {
        return $this->dateTime->format('Y-m-d H:i:s (e)');
    }

    /**
     * Gets the timezone of the date time.
     *
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->dateTime->getTimezone();
    }

    /**
     * Returns whether the datetime is greater than the supplied datetime.
     *
     * @param TimeZonedDateTime $other
     *
     * @return bool
     */
    public function comesAfter(TimeZonedDateTime $other)
    {
        return $this->dateTime > $other->dateTime;
    }

    /**
     * Returns whether the datetime is greater or equal to the supplied datetime.
     *
     * @param TimeZonedDateTime $other
     *
     * @return bool
     */
    public function comesAfterOrEqual(TimeZonedDateTime $other)
    {
        return $this->dateTime >= $other->dateTime;
    }

    /**
     * Returns whether the datetime is less than the supplied datetime.
     *
     * @param TimeZonedDateTime $other
     *
     * @return bool
     */
    public function comesBefore(TimeZonedDateTime $other)
    {
        return $this->dateTime < $other->dateTime;
    }

    /**
     * Returns whether the datetime is less or equal to the supplied datetime.
     *
     * @param TimeZonedDateTime $other
     *
     * @return bool
     */
    public function comesBeforeOrEqual(TimeZonedDateTime $other)
    {
        return $this->dateTime <= $other->dateTime;
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return static
     */
    protected function createFromNativeObject(\DateTimeInterface $dateTime)
    {
        return new self($dateTime);
    }

    /**
     * Returns the current date time regardless
     * of the set timezone.
     *
     * @return DateTime
     */
    public function regardlessOfTimezone()
    {
        return new DateTime($this->dateTime);
    }

    /**
     * Returns the current date time according to the supplied timezone
     *
     * @param string $timezoneId
     *
     * @return TimeZonedDateTime
     */
    public function convertTimezone($timezoneId)
    {
        return new TimeZonedDateTime(
                (new \DateTimeImmutable('now', new \DateTimeZone($timezoneId)))
                        ->setTimestamp($this->dateTime->getTimestamp())
        );
    }
}