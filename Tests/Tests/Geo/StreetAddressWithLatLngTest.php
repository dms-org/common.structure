<?php

namespace Dms\Common\Structure\Tests\Geo;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLngTest extends CmsTestCase
{
    public function testNew()
    {
        $address = new StreetAddressWithLatLng('abc', $latLng = new LatLng(-10.0, 10.0));

        $this->assertSame('abc', $address->getAddress());
        $this->assertSame($latLng, $address->getLatLng());
    }
}