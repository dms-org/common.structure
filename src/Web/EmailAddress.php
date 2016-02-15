<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Web;

use Dms\Common\Structure\Type\StringValueObject;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * The email address value object class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EmailAddress extends StringValueObject
{
    /**
     * @see http://stackoverflow.com/questions/386294/what-is-the-maximum-length-of-a-valid-email-address
     */
    const MAX_LENGTH = 254;

    /**
     * Validates the string is in the required format.
     *
     * @param string $string
     *
     * @return void
     * @throws InvalidArgumentException
     */
    protected function validateString(string $string)
    {
        if (strlen($string) > self::MAX_LENGTH || !filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw InvalidArgumentException::format(
                    'Cannot construct class %s: argument must be a valid email address, \'%s\' given',
                    get_class($this), $string
            );
        }
    }
}