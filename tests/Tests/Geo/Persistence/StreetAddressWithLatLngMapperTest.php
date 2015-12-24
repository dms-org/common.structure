<?php

namespace Dms\Common\Structure\Tests\Geo\Persistence;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\Persistence\StreetAddressWithLatLngMapper;
use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLngMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new StreetAddressWithLatLngMapper('address', 'lat', 'lng');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [
                        ['address' => '123 Abc st', 'lat' => -1.0, 'lng' => 20.0],
                        new StreetAddressWithLatLng('123 Abc st', new LatLng(-1.0, 20.0))
                ],
                [
                        ['address' => 'Eureka Tower, Bright St, Southbank VIC 3006', 'lat' => -37.821638, 'lng' => 144.9623461],
                        new StreetAddressWithLatLng('Eureka Tower, Bright St, Southbank VIC 3006', new LatLng(-37.821638, 144.9623461))
                ],
        ];
    }
}