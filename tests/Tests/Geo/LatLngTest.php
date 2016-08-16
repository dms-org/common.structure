<?php

namespace Dms\Common\Structure\Tests\Geo;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Testing\CmsTestCase;
use Dms\Core\Exception\InvalidArgumentException;

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
        $this->assertThrows(function () {
            new LatLng('sfdf', 'sdf');
        }, \TypeError::class);
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

    public function testGetDistanceFrom()
    {
        $centerOfMelbourne = new LatLng(-37.9716929, 144.7729596);
        $centerOfSydney    = new LatLng(-33.8479269, 150.7918918);
        $centerOfBrisbane  = new LatLng(-27.3818631, 152.7130056);

        $this->assertSame(0.0, $centerOfMelbourne->getDistanceFromInKm($centerOfMelbourne));
        $this->assertSame(0.0, $centerOfSydney->getDistanceFromInKm($centerOfSydney));

        $this->assertSame(709.70729903482595, $centerOfMelbourne->getDistanceFromInKm($centerOfSydney));
        $this->assertSame(709.70729903482595, $centerOfSydney->getDistanceFromInKm($centerOfMelbourne));

        $this->assertSame(1391.076545765965, $centerOfMelbourne->getDistanceFromInKm($centerOfBrisbane));

        $this->assertSame(742.07481121499222, $centerOfSydney->getDistanceFromInKm($centerOfBrisbane));
    }
}