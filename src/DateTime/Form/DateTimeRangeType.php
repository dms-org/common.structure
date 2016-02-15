<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Model\Type\IType;

/**
 * The datetime range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeType extends DateOrTimeRangeType
{
    /**
     * @param Field  $field
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    protected function buildRangeInput(Field $field, string $format) : FieldBuilderBase
    {
        return $field->datetime($format);
    }

    /**
     * @return IType
     */
    protected function processedRangeType() : IType
    {
        return DateTimeRange::type();
    }

    /**
     * @param mixed $start
     * @param mixed $end
     *
     * @return mixed
     */
    protected function buildRangeObject($start, $end)
    {
        return new DateTimeRange(
                new DateTime($start),
                new DateTime($end)
        );
    }

    /**
     * @param DateTimeRange $range
     *
     * @return mixed
     */
    protected function getRangeStart($range)
    {
        return $range->getStart()->getNativeDateTime();
    }

    /**
     * @param DateTimeRange $range
     *
     * @return mixed
     */
    protected function getRangeEnd($range)
    {
        return $range->getEnd()->getNativeDateTime();
    }
}