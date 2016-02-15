<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
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
     * @return FieldBuilderBase
     */
    protected function buildRangeInput(Field $field, string $format) : FieldBuilderBase
    {
        return $field->type(new TimezonedDateTimeType($format));
    }

    /**
     * @return IType
     */
    protected function processedRangeType() : IType
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