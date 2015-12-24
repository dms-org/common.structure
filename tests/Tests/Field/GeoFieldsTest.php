<?php

namespace Dms\Common\Structure\Tests\Field;

use Dms\Common\Structure\Field;
use Dms\Common\Structure\Geo\Form\LatLngType;
use Dms\Common\Structure\Geo\Form\StreetAddressType;
use Dms\Common\Structure\Geo\Form\StreetAddressWithLatLngType;
use Dms\Common\Testing\CmsTestCase;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class GeoFieldsTest extends CmsTestCase
{
    public function testStreetAddress()
    {
        $type = Field::forType()->streetAddress()
                ->build()
                ->getType();

        $this->assertInstanceOf(StreetAddressType::class, $type);
    }

    public function testLatLng()
    {
        $type = Field::forType()->latLng()
                ->build()
                ->getType();

        $this->assertInstanceOf(LatLngType::class, $type);
    }

    public function testStreetAddressWithLatLng()
    {
        $type = Field::forType()->streetAddressWithLatLng()
                ->build()
                ->getType();

        $this->assertInstanceOf(StreetAddressWithLatLngType::class, $type);
    }
}