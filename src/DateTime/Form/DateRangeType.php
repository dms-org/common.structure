<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateRange;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Model\Type\IType;

/**
 * The date range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeType extends DateOrTimeRangeType
{
    /**
     * @param Field  $field
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    protected function buildRangeInput(Field $field, string $format) : FieldBuilderBase
    {
        return $field->date($format);
    }

    /**
     * @return IType
     */
    protected function processedRangeType() : IType
    {
        return DateRange::type();
    }

    /**
     * @param mixed $start
     * @param mixed $end
     *
     * @return mixed
     */
    protected function buildRangeObject($start, $end)
    {
        return new DateRange(
            Date::fromNative($start),
            Date::fromNative($end)
        );
    }

    /**
     * @param DateRange $range
     *
     * @return mixed
     */
    protected function getRangeStart($range)
    {
        return $range->getStart()->getNativeDateTime();
    }

    /**
     * @param DateRange $range
     *
     * @return mixed
     */
    protected function getRangeEnd($range)
    {
        return $range->getEnd()->getNativeDateTime();
    }
}