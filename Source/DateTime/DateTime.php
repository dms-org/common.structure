<?php

namespace Dms\Common\Structure\DateTime;

/**
 * The date time value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTime extends DateTimeBase
{
    /**
     * @param \DateTimeInterface $dateTime
     */
    public function __construct(\DateTimeInterface $dateTime)
    {
        parent::__construct(
                \DateTimeImmutable::createFromFormat(
                        'Y-m-d H:i:s',
                        $dateTime->format('Y-m-d H:i:s'),
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
    public static function fromString($dateTimeString)
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
    public static function fomFormat($format, $dateString)
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
    public function debugFormat()
    {
        return $this->dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @inheritDoc
     */
    protected function serializationFormat()
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * @inheritDoc
     */
    protected function getValidDateFormatChars()
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
    public function comesAfter(DateTime $other)
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
    public function comesAfterOrEqual(DateTime $other)
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
    public function comesBefore(DateTime $other)
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
    public function comesBeforeOrEqual(DateTime $other)
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
    public function inTimezone($timeZoneId)
    {
        return new TimezonedDateTime(
                \DateTimeImmutable::createFromFormat(
                        'Y-m-d H:i:s',
                        $this->format('Y-m-d H:i:s'),
                        new \DateTimeZone($timeZoneId)
                )
        );
    }
}