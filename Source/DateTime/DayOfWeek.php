<?php

namespace Dms\Common\Structure\DateTime;

use Dms\Core\Model\Object\Enum;
use Dms\Core\Model\Object\InvalidEnumValueException;
use Dms\Core\Model\Object\PropertyTypeDefiner;

/**
 * The day of week enum.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DayOfWeek extends Enum
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    /**
     * @var string[]
     */
    private static $shortNames = [
            self::MONDAY    => 'Mon',
            self::TUESDAY   => 'Tue',
            self::WEDNESDAY => 'Wed',
            self::THURSDAY  => 'Thu',
            self::FRIDAY    => 'Fri',
            self::SATURDAY  => 'Sat',
            self::SUNDAY    => 'Sun',
    ];

    /**
     * @var string[]
     */
    private static $fullNames = [
            self::MONDAY    => 'Monday',
            self::TUESDAY   => 'Tuesday',
            self::WEDNESDAY => 'Wednesday',
            self::THURSDAY  => 'Thursday',
            self::FRIDAY    => 'Friday',
            self::SATURDAY  => 'Saturday',
            self::SUNDAY    => 'Sunday',
    ];

    /**
     * Defines the type of the options contained within the enum.
     *
     * @param PropertyTypeDefiner $values
     *
     * @return void
     */
    protected function defineEnumValues(PropertyTypeDefiner $values)
    {
        $values->asInt();
    }

    /**
     * @return DayOfWeek
     */
    public static function monday()
    {
        return new self(self::MONDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function tuesday()
    {
        return new self(self::TUESDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function wednesday()
    {
        return new self(self::WEDNESDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function thursday()
    {
        return new self(self::THURSDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function friday()
    {
        return new self(self::FRIDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function saturday()
    {
        return new self(self::SATURDAY);
    }

    /**
     * @return DayOfWeek
     */
    public static function sunday()
    {
        return new self(self::SUNDAY);
    }

    /**
     * Gets the weekdays.
     *
     * @return DayOfWeek[]
     */
    public static function weekdays()
    {
        $days     = self::getAll();
        $weekDays = [];

        foreach ($days as $key => $day) {
            if ($day->isWeekDay()) {
                $weekDays[] = $day;
            }
        }

        return $weekDays;
    }

    /**
     * Gets the weekend days.
     *
     * @return DayOfWeek[]
     */
    public static function weekends()
    {
        $days        = self::getAll();
        $weekEndDays = [];

        foreach ($days as $key => $day) {
            if ($day->isWeekEnd()) {
                $weekEndDays[] = $day;
            }
        }

        return $weekEndDays;
    }

    /**
     * Gets the day of the week from the supplied name string.
     *
     * NOTE: casing is ignored.
     *
     * @param string $name
     *
     * @return DayOfWeek
     * @throws InvalidEnumValueException
     */
    public static function fromShortName($name)
    {
        return self::fromNameMap($name, self::$shortNames, __METHOD__);
    }

    /**
     * Gets the day of the week from the supplied name string.
     *
     * NOTE: casing is ignored.
     *
     * @param string $name
     *
     * @return DayOfWeek
     * @throws InvalidEnumValueException
     */
    public static function fromName($name)
    {
        return self::fromNameMap($name, self::$fullNames, __METHOD__);
    }

    /**
     * @param string   $name
     * @param string[] $nameMap
     * @param string   $method
     *
     * @return DayOfWeek
     * @throws InvalidEnumValueException
     */
    private static function fromNameMap($name, array $nameMap, $method)
    {
        $name = ucfirst(strtolower($name));

        $ordinal = array_search($name, $nameMap, true);

        if ($ordinal === false) {
            throw new InvalidEnumValueException($method, $nameMap, $name);
        }

        return new self($ordinal);
    }

    /**
     * @return string[]
     */
    public static function getShortNameMap()
    {
        return self::$shortNames;
    }

    /**
     * @return string[]
     */
    public static function getNameMap()
    {
        return self::$fullNames;
    }

    /**
     * Gets the ordinal number of the day of the week.
     *
     * Example:
     * <code>
     * DayOfWeek::saturday()->getOrdinal(); // 6
     * </code>
     *
     * @return int
     */
    public function getOrdinal()
    {
        return $this->getValue();
    }

    /**
     * Gets a 3-letter representation of the day of the week.
     *
     * Example:
     * <code>
     * DayOfWeek::tuesday()->getShortName(); // 'Tue'
     * </code>
     *
     * @return string
     */
    public function getShortName()
    {
        return self::$shortNames[$this->getValue()];
    }

    /**
     * Gets the full name of the day of the week.
     *
     * Example:
     * <code>
     * DayOfWeek::wednesday()->getShortName(); // 'Wednesday'
     * </code>
     *
     * @return string
     */
    public function getName()
    {
        return self::$fullNames[$this->getValue()];
    }

    /**
     * Returns whether the day is a week day.
     *
     * @return bool
     */
    public function isWeekDay()
    {
        return $this->getOrdinal() <= 5;
    }

    /**
     * @return bool
     */
    public function isWeekEnd()
    {
        return $this->getOrdinal() >= 6;
    }
}