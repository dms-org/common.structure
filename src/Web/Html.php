<?php

namespace Dms\Common\Structure\Web;

use Dms\Common\Structure\Type\StringValueObject;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * The html value object class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Html extends StringValueObject
{
    /**
     * Validates the string is in the required format.
     *
     * @param string $string
     *
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validateString($string)
    {

    }
}