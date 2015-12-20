<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo;

use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\StringAddressWithLatLng;
use Iddigital\Cms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressWithLatLngTest extends CmsTestCase
{
    public function testNew()
    {
        $address = new StringAddressWithLatLng('abc', $latLng = new LatLng(-10.0, 10.0));

        $this->assertSame('abc', $address->asString());
        $this->assertSame($latLng, $address->getLatLng());
    }
}