<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\TimeOfDayType as BaseTimeOfDayType;

/**
 * The time of day field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeOfDayType extends BaseTimeOfDayType
{
    /**
     * TimeOfDayType constructor.
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
                        TimeOfDay::type(),
                        function (\DateTimeImmutable $input) {
                            return TimeOfDay::fromNative($input);
                        },
                        function (TimeOfDay $time) {
                            return $time->getNativeDateTime();
                        }
                )
        ]);
    }
}