<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo;

use Iddigital\Cms\Common\Structure\Geo\StreetAddress;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\InvalidPropertyValueException;

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