<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Geo;

use Dms\Common\Structure\Type\StringValueObject;
use Dms\Core\Exception\InvalidArgumentException;

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
    protected function validateString(string $string)
    {
        if (!$string) {
            throw InvalidArgumentException::format(
                    'Invalid address string supplied to %s: address cannot be empty',
                    __CLASS__
            );
        }
    }
}