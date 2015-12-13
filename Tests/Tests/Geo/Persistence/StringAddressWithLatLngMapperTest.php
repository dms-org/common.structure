<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\Persistence\StringAddressMapper;
use Iddigital\Cms\Common\Structure\Geo\Persistence\StringAddressWithLatLngMapper;
use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Common\Structure\Geo\StringAddressWithLatLng;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressWithLatLngMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new StringAddressWithLatLngMapper('address', 'lat', 'lng');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['address' => '123 Abc st', 'lat' => -1.0, 'lng' => 20.0], new StringAddressWithLatLng('123 Abc st', new LatLng(-1.0, 20.0))],
                [
                        ['address' => 'Eureka Tower, Bright St, Southbank VIC 3006', 'lat' => -37.821638, 'lng' => 144.9623461],
                        new StringAddressWithLatLng('Eureka Tower, Bright St, Southbank VIC 3006', new LatLng(-37.821638,144.9623461))
                ],
        ];
    }
}