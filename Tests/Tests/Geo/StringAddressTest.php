<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo;

use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Common\Testing\CmsTestCase;
use Iddigital\Cms\Core\Exception\InvalidArgumentException;
use Iddigital\Cms\Core\Model\Object\InvalidPropertyValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressTest extends CmsTestCase
{
    public function testNew()
    {
        $address = new StringAddress('abc');

        $this->assertSame('abc', $address->asString());
    }

    public function testInvalidType()
    {
        // Must be string

        $this->assertThrows(function () {
            new StringAddress(123);
        }, InvalidPropertyValueException::class);
    }

    public function testInvalidAddress()
    {
        $this->assertThrows(function () {
            new StringAddress('');
        }, InvalidArgumentException::class);
    }
}