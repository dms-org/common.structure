<?php

namespace Iddigital\Cms\Common\Structure\Tests\Geo\Persistence;

use Iddigital\Cms\Common\Structure\Geo\Persistence\StringAddressMapper;
use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new StringAddressMapper('address');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['address' => '123 Abc st'], new StringAddress('123 Abc st')],
                [
                        ['address' => 'Eureka Tower, Bright St, Southbank VIC 3006'],
                        new StringAddress('Eureka Tower, Bright St, Southbank VIC 3006')
                ],
        ];
    }
}