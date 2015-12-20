<?php

namespace Dms\Common\Structure\Tests\Web\Persistence;

use Dms\Common\Structure\Web\IpAddress;
use Dms\Common\Structure\Web\Persistence\IpAddressMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class IpAddressMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new IpAddressMapper('ip');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['ip' => '123.123.123.123'], new IpAddress('123.123.123.123')],
                [['ip' => 'FE80:0000:0000:0000:0202:B3FF:FE1E:8329'], new IpAddress('FE80:0000:0000:0000:0202:B3FF:FE1E:8329')],
        ];
    }
}