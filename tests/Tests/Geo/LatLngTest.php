<?php

namespace Dms\Common\Structure\Tests\Geo;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Model\Object\InvalidPropertyValueException;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLngTest extends CmsTestCase
{
    public function testNew()
    {
        $latLng = new LatLng(-10.0, 20.0);

        $this->assertSame(-10.0, $latLng->getLat());
        $this->assertSame(20.0, $latLng->getLng());
    }

    public function testInvalidType()
    {
        // Must be floats

        $this->assertThrows(function () {
            new LatLng(-10, 20.0);
        }, InvalidPropertyValueException::class);

        $this->assertThrows(function () {
            new LatLng(-10.0, 20);
        }, InvalidPropertyValueException::class);

        $this->assertThrows(function () {
            new LatLng('-10.0', '20.0');
        }, InvalidPropertyValueException::class);
    }

    public function testInvalidLatitude()
    {
        $this->assertThrows(function () {
            new LatLng(-90.1, 0);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new LatLng(90.1, 0);
        }, InvalidArgumentException::class);
    }

    public function testInvalidLongitude()
    {
        $this->assertThrows(function () {
            new LatLng(0, -180.1);
        }, InvalidArgumentException::class);

        $this->assertThrows(function () {
            new LatLng(0, 180.1);
        }, InvalidArgumentException::class);
    }
}