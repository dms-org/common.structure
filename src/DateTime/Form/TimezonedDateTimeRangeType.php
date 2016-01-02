<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\IForm;
use Dms\Core\Model\Type\IType;

/**
 * The timezoned datetime range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeType extends DateOrTimeRangeType
{
    /**
     * @param Field  $field
     * @param string $format
     *
     * @return Field
     */
    protected function buildRangeInput(Field $field, $format)
    {
        return $field->type(new TimezonedDateTimeType($format));
    }

    /**
     * @return IType
     */
    protected function processedRangeType()
    {
        return TimezonedDateTimeRange::type();
    }

    /**
     * @param mixed $start
     * @param mixed $end
     *
     * @return mixed
     */
    protected function buildRangeObject($start, $end)
    {
        return new TimezonedDateTimeRange($start, $end);
    }

    /**
     * @param TimezonedDateTimeRange $range
     *
     * @return mixed
     */
    protected function getRangeStart($range)
    {
        return $range->getStart();
    }

    /**
     * @param TimezonedDateTimeRange $range
     *
     * @return mixed
     */
    protected function getRangeEnd($range)
    {
        return $range->getEnd();
    }
}