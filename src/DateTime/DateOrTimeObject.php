<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime;

use Dms\Core\Model\IComparable;
use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\ValueObject;
use Dms\Core\Util\Hashing\IHashable;

/**
 * The date time object base
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DateOrTimeObject extends ValueObject implements IComparable, IHashable
{
    const DATE_TIME = 'dateTime';

    /**
     * @var \DateTimeImmutable
     */
    protected $dateTime;

    /**
     * DateOrTimeObject constructor.
     *
     * @param \DateTimeImmutable $dateTime
     */
    public function __construct(\DateTimeImmutable $dateTime)
    {
        parent::__construct();
        $this->dateTime = $dateTime;
    }

    /**
     * Gets the date/time formatted as a string for debugging purposes.
     *
     * @return string
     */
    abstract public function debugFormat() : string;

    /**
     * Gets the date/time format string for use during serialization.
     *
     * This should contain ALL the date/time fields used by this date/time instance.
     *
     * @see http://php.net/manual/en/function.date.php
     *
     * @return string
     */
    abstract protected function serializationFormat() : string;

    /**
     * Gets a valid date/time formatting characters.
     *
     * @see http://php.net/manual/en/function.date.php
     *
     * @return string[]
     */
    abstract protected function getValidDateFormatChars() : array;

    /**
     * {@inheritDoc}
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->dateTime)->asObject(\DateTimeImmutable::class);
    }

    /**
     * @inheritDoc
     */
    protected function dataToSerialize()
    {
        return $this->dateTime->format($this->serializationFormat());
    }

    /**
     * @inheritDoc
     */
    protected function hydrateFromSerializedData($deserializedData)
    {
        $timezone = $this->deserializationTimeZone();
        $format   = '!' . $this->serializationFormat();

        if ($timezone) {
            $this->dateTime = \DateTimeImmutable::createFromFormat($format, $deserializedData, $timezone);
        } else {
            $this->dateTime = \DateTimeImmutable::createFromFormat($format, $deserializedData);
        }
    }

    /**
     * @return \DateTimeZone|null
     */
    protected function deserializationTimeZone()
    {
        return new \DateTimeZone('UTC');
    }

    /**
     * Gets the internal date time object.
     *
     * @return \DateTimeImmutable
     */
    public function getNativeDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Formats the date/time as a string.
     *
     * @param string $format
     *
     * @return string
     */
    public function format(string $format) : string
    {
        $format = $this->escapeUnapplicableFormatChars($format);

        return $this->dateTime->format($format);
    }

    /**
     * Escapes any format characters that are not valid for this date/time object.
     *
     * @param string $format
     *
     * @return string
     */
    protected function escapeUnapplicableFormatChars(string $format) : string
    {
        $validChars      = $this->getValidDateFormatChars();
        $validCharLookup = array_fill_keys($validChars, true);

        $escapedFormat = '';
        $isEscaped     = false;

        foreach (str_split($format) as $char) {
            if ($isEscaped) {
                $escapedFormat .= '\\' . $char;
                $isEscaped = false;
            } elseif ($char === '\\') {
                $isEscaped = true;
            } elseif (isset($validCharLookup[$char])) {
                $escapedFormat .= $char;
            } else {
                $escapedFormat .= '\\' . $char;
            }
        }

        return $escapedFormat;
    }

    /**
     * Returns a new object with the supplied interval added.
     *
     * @param \DateInterval $interval
     *
     * @return static
     */
    public function add(\DateInterval $interval)
    {
        return $this->createFromNativeObject($this->dateTime->add($interval));
    }

    /**
     * Returns a new object with the supplied interval subtracted.
     *
     * @param \DateInterval $interval
     *
     * @return static
     */
    public function sub(\DateInterval $interval)
    {
        return $this->createFromNativeObject($this->dateTime->sub($interval));
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return static
     */
    abstract protected function createFromNativeObject(\DateTimeInterface $dateTime);
}