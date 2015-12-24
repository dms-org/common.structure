<?php

namespace Dms\Common\Structure\Tests\Table\Fixtures;

use Dms\Core\Model\Object\Enum;
use Dms\Core\Model\Object\PropertyTypeDefiner;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestBusinessAvailability extends Enum
{
    const OPEN = 'open';
    const CLOSED = 'closed';

    /**
     * @return TestBusinessAvailability
     */
    public static function open()
    {
        return new self(self::OPEN);
    }

    /**
     * @return TestBusinessAvailability
     */
    public static function closed()
    {
        return new self(self::CLOSED);
    }

    /**
     * Defines the type of the options contained within the enum.
     *
     * @param PropertyTypeDefiner $values
     *
     * @return void
     */
    protected function defineEnumValues(PropertyTypeDefiner $values)
    {
        $values->asString();
    }
}