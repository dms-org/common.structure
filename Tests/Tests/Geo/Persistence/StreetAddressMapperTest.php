<?php

namespace Dms\Common\Structure\Tests\Geo\Persistence;

use Dms\Common\Structure\Geo\Persistence\StreetAddressMapper;
use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new StreetAddressMapper('address');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['address' => '123 Abc st'], new StreetAddress('123 Abc st')],
                [
                        ['address' => 'Eureka Tower, Bright St, Southbank VIC 3006'],
                        new StreetAddress('Eureka Tower, Bright St, Southbank VIC 3006')
                ],
        ];
    }
}