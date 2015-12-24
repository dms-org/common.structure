<?php

namespace Dms\Common\Structure\DateTime\Form\Builder;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\Form\DateTimeType;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The date/time field builder
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeFieldBuilder extends FieldBuilderBase
{
    /**
     * Validates the date/time is greater than or equal to the supplied date/time
     *
     * @param DateTime $min
     *
     * @return static
     */
    public function min(DateTime $min)
    {
        return $this->attr(DateTimeType::ATTR_MIN, $min->getNativeDateTime());
    }

    /**
     * Validates the date/time is greater than the supplied date/time
     *
     * @param DateTime $value
     *
     * @return static
     */
    public function greaterThan(DateTime $value)
    {
        return $this->attr(DateTimeType::ATTR_GREATER_THAN, $value->getNativeDateTime());
    }

    /**
     * Validates the date/time is less than or equal to the supplied date/time
     *
     * @param DateTime $max
     *
     * @return static
     */
    public function max(DateTime $max)
    {
        return $this->attr(DateTimeType::ATTR_MAX, $max->getNativeDateTime());
    }

    /**
     * Validates the date/time is greater than the supplied date/time
     *
     * @param DateTime $value
     *
     * @return static
     */
    public function lessThan(DateTime $value)
    {
        return $this->attr(DateTimeType::ATTR_LESS_THAN, $value->getNativeDateTime());
    }
}