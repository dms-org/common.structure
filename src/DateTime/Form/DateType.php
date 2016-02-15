<?php declare(strict_types = 1);

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\DateType as BaseDateType;

/**
 * The date field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateType extends BaseDateType
{
    /**
     * DateType constructor.
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
                        Date::type(),
                        function ($input) {
                            return Date::fromNative($input);
                        },
                        function (Date $date) {
                            return $date->getNativeDateTime();
                        }
                )
        ]);
    }
}