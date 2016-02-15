<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\DateTimeType as BaseDateTimeType;

/**
 * The timezoned datetime field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeType extends BaseDateTimeType
{
    /**
     * TimezonedDateTimeType constructor.
     *
     * @param string $format
     */
    public function __construct(string $format)
    {
        parent::__construct($format);
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors() : array
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        TimezonedDateTime::type(),
                        function (\DateTimeImmutable $input) {
                            return new TimezonedDateTime($input);
                        },
                        function (TimezonedDateTime $dateTime) {
                            return $dateTime->getNativeDateTime();
                        }
                )
        ]);
    }
}