<?php

namespace Dms\Common\Structure\Tests\Web;

use Dms\Common\Structure\Web\IpAddress;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class IpAddressString extends CmsTestCase
{
    public function testIpAddressV4()
    {
        $ipAddress = new IpAddress('123.123.123.123');

        $this->assertSame('123.123.123.123', $ipAddress->asString());
    }

    public function testIpAddressV6()
    {
        $ipAddress = new IpAddress('FE80:0000:0000:0000:0202:B3FF:FE1E:8329');

        $this->assertSame('FE80:0000:0000:0000:0202:B3FF:FE1E:8329', $ipAddress->asString());
    }

    public function testInvalidIpAddress()
    {
        $invalidIpAddresses = [
                'abc',
                '122.131.234',
                '24234325352432',
        ];

         foreach ($invalidIpAddresses as $ipAddressString) {
             $this->assertThrows(function () use($ipAddressString) {
                 new IpAddress($ipAddressString);
             }, InvalidArgumentException::class);
         }
    }
}