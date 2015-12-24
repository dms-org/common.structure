<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\DateTimeType as BaseDateTimeType;

/**
 * The datetime field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeType extends BaseDateTimeType
{
    /**
     * DateTimeType constructor.
     *
     * @param string $format
     */
    public function __construct($format)
    {
        parent::__construct($format);
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        DateTime::type(),
                        function (\DateTimeImmutable $input) {
                            return new DateTime($input);
                        },
                        function (DateTime $dateTime) {
                            return $dateTime->getNativeDateTime();
                        }
                )
        ]);
    }
}