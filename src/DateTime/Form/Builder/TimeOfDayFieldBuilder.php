<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form\Builder;

use Dms\Common\Structure\DateTime\Form\TimeOfDayType;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The time field builder
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDayFieldBuilder extends FieldBuilderBase
{
    /**
     * Validates the time is greater than or equal to the supplied time
     *
     * @param TimeOfDay $min
     *
     * @return static
     */
    public function min(TimeOfDay $min)
    {
        return $this->attr(TimeOfDayType::ATTR_MIN, $min->getNativeDateTime());
    }

    /**
     * Validates the time is greater than the supplied time
     *
     * @param TimeOfDay $value
     *
     * @return static
     */
    public function greaterThan(TimeOfDay $value)
    {
        return $this->attr(TimeOfDayType::ATTR_GREATER_THAN, $value->getNativeDateTime());
    }

    /**
     * Validates the time is less than or equal to the supplied time
     *
     * @param TimeOfDay $max
     *
     * @return static
     */
    public function max(TimeOfDay $max)
    {
        return $this
                ->attr(TimeOfDayType::ATTR_MAX, $max->getNativeDateTime());
    }

    /**
     * Validates the time is greater than the supplied time
     *
     * @param TimeOfDay $value
     *
     * @return static
     */
    public function lessThan(TimeOfDay $value)
    {
        return $this->attr(TimeOfDayType::ATTR_LESS_THAN, $value->getNativeDateTime());
    }
}