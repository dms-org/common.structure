<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

/**
 * The date time value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTime extends DateTimeBase
{
    const DISPLAY_FORMAT = Date::DISPLAY_FORMAT . ' ' . TimeOfDay::DEFAULT_FORMAT;
    const SERIALIZE_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param \DateTimeInterface $dateTime
     */
    public function __construct(\DateTimeInterface $dateTime)
    {
        parent::__construct(
                \DateTimeImmutable::createFromFormat(
                        self::SERIALIZE_FORMAT,
                        $dateTime->format(self::SERIALIZE_FORMAT),
                        new \DateTimeZone('UTC')
                )
        );
    }

    /**
     * Creates a DateTime object from the supplied date string
     *
     * @param string $dateTimeString
     *
     * @return DateTime
     */
    public static function fromString(string $dateTimeString) : DateTime
    {
        return new self(new \DateTimeImmutable(
                $dateTimeString,
                new \DateTimeZone('UTC')
        ));
    }

    /**
     * Creates a DateTime object from the supplied format string
     *
     * @param string $format
     * @param string $dateString
     *
     * @return DateTime
     */
    public static function fomFormat(string $format, string $dateString) : DateTime
    {
        return new self(\DateTimeImmutable::createFromFormat('!' . $format, $dateString));
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
     * @inheritDoc
     */
    public function debugFormat() : string
    {
        return $this->dateTime->format(self::DISPLAY_FORMAT);
    }

    /**
     * @inheritDoc
     */
    protected function serializationFormat() : string
    {
        return self::SERIALIZE_FORMAT;
    }

    /**
     * @inheritDoc
     */
    protected function getValidDateFormatChars() : array
    {
        return [
            // @formatter:off
            'd', 'D', 'j', 'l', 'N', 'S', 'w', 'z', 'W', 'F', 'm', 'M', 'n', 't',
            'L', 'o', 'Y', 'y', 'a', 'A', 'B', 'g', 'G', 'h', 'H', 'i', 's', 'c',
            'r', 'U'
            // @formatter:on
        ];
    }

    /**
     * Returns whether the datetime is greater than the supplied datetime.
     *
     * @param DateTime $other
     *
     * @return bool
     */
    public function comesAfter(DateTime $other) : bool
    {
        return $this->dateTime > $other->dateTime;
    }

    /**
     * Returns whether the datetime is greater or equal to the supplied datetime.
     *
     * @param DateTime $other
     *
     * @return bool
     */
    public function comesAfterOrEqual(DateTime $other) : bool
    {
        return $this->dateTime >= $other->dateTime;
    }

    /**
     * Returns whether the datetime is less than the supplied datetime.
     *
     * @param DateTime $other
     *
     * @return bool
     */
    public function comesBefore(DateTime $other) : bool
    {
        return $this->dateTime < $other->dateTime;
    }

    /**
     * Returns whether the datetime is less or equal to the supplied datetime.
     *
     * @param DateTime $other
     *
     * @return bool
     */
    public function comesBeforeOrEqual(DateTime $other) : bool
    {
        return $this->dateTime <= $other->dateTime;
    }

    /**
     * Returns the current date time as if it were in the supplied timezone
     *
     * @param string $timeZoneId
     *
     * @return TimezonedDateTime
     */
    public function inTimezone(string $timeZoneId) : TimezonedDateTime
    {
        return new TimezonedDateTime(
                \DateTimeImmutable::createFromFormat(
                        self::DISPLAY_FORMAT,
                        $this->format(self::DISPLAY_FORMAT),
                        new \DateTimeZone($timeZoneId)
                )
        );
    }
}