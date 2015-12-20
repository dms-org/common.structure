<?php

namespace Iddigital\Cms\Common\Structure\Web;

use Iddigital\Cms\Common\Structure\Type\StringValueObject;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * The ip address value object class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class IpAddress extends StringValueObject
{
    /**
     * See http://stackoverflow.com/questions/1076714/max-length-for-client-ip-address
     */
    const MAX_LENGTH = 45;

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
        if (strlen($string) > self::MAX_LENGTH || !filter_var($string, FILTER_VALIDATE_IP)) {
            throw InvalidArgumentException::format(
                    'Cannot construct class %s: argument must be a valid ip address, \'%s\' given',
                    get_class($this), $string
            );
        }
    }
}