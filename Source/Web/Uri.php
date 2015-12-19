<?php

namespace Iddigital\Cms\Common\Structure\Web;

use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * The uri value object class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class Uri extends StringValueObject
{
    /**
     * @see http://stackoverflow.com/questions/219569/best-database-field-type-for-a-url
     */
    const MAX_LENGTH = 2083;


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
        if (strlen($string) > self::MAX_LENGTH || !filter_var($string, FILTER_VALIDATE_URL)) {
            throw InvalidArgumentException::format(
                    'Cannot construct class %s: argument must be a valid uri, \'%s\' given',
                    get_class($this), $string
            );
        }
    }
}