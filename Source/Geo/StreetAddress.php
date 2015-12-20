<?php

namespace Iddigital\Cms\Common\Structure\Geo;

use Iddigital\Cms\Common\Structure\Type\StringValueObject;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;

/**
 * The string address value object.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddress extends StringValueObject
{
    const MAX_LENGTH = 100;

    /**
     * @inheritDoc
     */
    protected function validateString($string)
    {
        if (!$string) {
            throw InvalidArgumentException::format(
                    'Invalid address string supplied to %s: address cannot be empty',
                    __CLASS__
            );
        }
    }
}