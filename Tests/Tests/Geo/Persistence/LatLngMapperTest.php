<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\Persistence\LatLngMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLngMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new LatLngMapper('lat', 'lng');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['lat' => 10.0, 'lng' => 20.0], new LatLng(10.0, 20.0)],
                [['lat' => -33.333333, 'lng' => 120.3134243], new LatLng(-33.333333, 120.3134243)],
        ];
    }
}