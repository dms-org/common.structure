<?php

namespace Dms\Common\Structure\Tests\Geo;

use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\InvalidPropertyValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressTest extends CmsTestCase
{
    public function testNew()
    {
        $address = new StreetAddress('abc');

        $this->assertSame('abc', $address->asString());
    }

    public function testInvalidType()
    {
        // Must be string

        $this->assertThrows(function () {
            new StreetAddress(123);
        }, InvalidPropertyValueException::class);
    }

    public function testInvalidAddress()
    {
        $this->assertThrows(function () {
            new StreetAddress('');
        }, InvalidArgumentException::class);
    }
}