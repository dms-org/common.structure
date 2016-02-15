<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimeRange;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Model\Type\IType;

/**
 * The time range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeType extends DateOrTimeRangeType
{
    /**
     * @param Field  $field
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    protected function buildRangeInput(Field $field, string $format) : FieldBuilderBase
    {
        return $field->time($format);
    }

    /**
     * @return IType
     */
    protected function processedRangeType() : IType
    {
        return TimeRange::type();
    }

    /**
     * @param mixed $start
     * @param mixed $end
     *
     * @return mixed
     */
    protected function buildRangeObject($start, $end)
    {
        return new TimeRange(
                TimeOfDay::fromNative($start),
                TimeOfDay::fromNative($end)
        );
    }

    /**
     * @param TimeRange $range
     *
     * @return mixed
     */
    protected function getRangeStart($range)
    {
        return $range->getStart()->getNativeDateTime();
    }

    /**
     * @param TimeRange $range
     *
     * @return mixed
     */
    protected function getRangeEnd($range)
    {
        return $range->getEnd()->getNativeDateTime();
    }
}