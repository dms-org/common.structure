<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Core\Exception\NotImplementedException;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;

/**
 * The date/time range field type base class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DateOrTimeRangeType extends InnerFormType
{
    const ATTR_FORMAT = 'format';

    /**
     * TimeRangeType constructor.
     *
     * @param string $format
     */
    public function __construct($format)
    {
        parent::__construct(static::form($format));
        $this->attributes[self::ATTR_FORMAT] = $format;
    }

    /**
     * @param string $format
     *
     * @return IForm
     * @throws NotImplementedException
     */
    public static function form($format)
    {
        throw NotImplementedException::format('Please override %s in subclass %s', __METHOD__, get_called_class());
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->attributes[self::ATTR_FORMAT];
    }
}