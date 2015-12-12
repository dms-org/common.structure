<?php

namespace Iddigital\Cms\Common\Structure\DateTime;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\ClassDefinition;
use Iddigital\Cms\Core\Model\Object\ValueObject;

/**
 * The date or time range value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DateOrTimeRangeObject extends ValueObject
{
    const START = 'start';
    const END = 'end';

    /**
     * @var DateOrTimeObject
     */
    protected $start;

    /**
     * @var DateOrTimeObject
     */
    protected $end;

    /**
     * DateOrTimeRangeObject constructor.
     *
     * @param DateOrTimeObject $start
     * @param DateOrTimeObject $end
     *
     * @throws InvalidArgumentException
     */
    public function __construct(DateOrTimeObject $start, DateOrTimeObject $end)
    {
        if ($start->getNativeDateTime() > $end->getNativeDateTime()) {
            throw InvalidArgumentException::format(
                    'Invalid start and end supplied to %s: the start must be less than or equal to the end, (start:%s | end:%s)',
                    get_class($this) . '::' . __FUNCTION__, $start->debugFormat(), $end->debugFormat()
            );
        }

        parent::__construct();

        $this->end   = $end;
        $this->start = $start;
    }

    /**
     * Gets the string of the date/time class of the start and end properties
     *
     * @return string
     */
    abstract protected function rangeOfClass();

    /**
     * @inheritDoc
     */
    protected function define(ClassDefinition $class)
    {
        $rangeOfClass = $this->rangeOfClass();
        $class->property($this->start)->asObject($rangeOfClass);
        $class->property($this->end)->asObject($rangeOfClass);
    }
}