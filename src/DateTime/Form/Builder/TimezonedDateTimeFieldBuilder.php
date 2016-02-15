<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form\Builder;

use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeType;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The timezoned date/time field builder
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeFieldBuilder extends FieldBuilderBase
{
    /**
     * Validates the timezoned date/time is greater than or equal to the supplied timezoned date/time
     *
     * @param TimezonedDateTime $min
     *
     * @return static
     */
    public function min(TimezonedDateTime $min)
    {
        return $this->attr(TimezonedDateTimeType::ATTR_MIN, $min->getNativeDateTime());
    }

    /**
     * Validates the timezoned date/time is greater than the supplied timezoned date/time
     *
     * @param TimezonedDateTime $value
     *
     * @return static
     */
    public function greaterThan(TimezonedDateTime $value)
    {
        return $this->attr(TimezonedDateTimeType::ATTR_GREATER_THAN, $value->getNativeDateTime());
    }

    /**
     * Validates the timezoned date/time is less than or equal to the supplied timezoned date/time
     *
     * @param TimezonedDateTime $max
     *
     * @return static
     */
    public function max(TimezonedDateTime $max)
    {
        return $this->attr(TimezonedDateTimeType::ATTR_MAX, $max->getNativeDateTime());
    }

    /**
     * Validates the timezoned date/time is greater than the supplied timezoned date/time
     *
     * @param TimezonedDateTime $value
     *
     * @return static
     */
    public function lessThan(TimezonedDateTime $value)
    {
        return $this->attr(TimezonedDateTimeType::ATTR_LESS_THAN, $value->getNativeDateTime());
    }
}