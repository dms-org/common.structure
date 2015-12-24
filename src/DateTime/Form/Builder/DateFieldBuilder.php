<?php

namespace Dms\Common\Structure\DateTime\Form\Builder;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\Form\DateType;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;

/**
 * The date field builder
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateFieldBuilder extends FieldBuilderBase
{
    /**
     * Validates the date is greater than or equal to the supplied date
     *
     * @param Date $min
     *
     * @return static
     */
    public function min(Date $min)
    {
        return $this->attr(DateType::ATTR_MIN, $min->getNativeDateTime());
    }

    /**
     * Validates the date is greater than the supplied date
     *
     * @param Date $value
     *
     * @return static
     */
    public function greaterThan(Date $value)
    {
        return $this->attr(DateType::ATTR_GREATER_THAN, $value->getNativeDateTime());
    }

    /**
     * Validates the date is less than or equal to the supplied date
     *
     * @param Date $max
     *
     * @return static
     */
    public function max(Date $max)
    {
        return $this->attr(DateType::ATTR_MAX, $max->getNativeDateTime());
    }

    /**
     * Validates the date is greater than the supplied date
     *
     * @param Date $value
     *
     * @return static
     */
    public function lessThan(Date $value)
    {
        return $this->attr(DateType::ATTR_LESS_THAN, $value->getNativeDateTime());
    }
}