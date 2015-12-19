<?php

namespace Iddigital\Cms\Common\Structure\Tests\Web\Persistence;

use Iddigital\Cms\Common\Structure\Web\EmailAddress;
use Iddigital\Cms\Common\Structure\Web\Persistence\EmailAddressMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EmailAddressMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new EmailAddressMapper('email');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
            [['email' => 'test@test.com'], new EmailAddress('test@test.com')],
            [['email' => 'abc@abc.com.au'], new EmailAddress('abc@abc.com.au')],
        ];
    }
}