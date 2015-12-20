<?php

namespace Dms\Common\Structure\Tests\Web\Persistence;

use Dms\Common\Structure\Web\Uri;
use Dms\Common\Structure\Web\Persistence\UriMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UriMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new UriMapper('uri');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['uri' => 'http://google.com.au'], new Uri('http://google.com.au')],
                [['uri' => 'http://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers'], new Uri('http://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers')],
        ];
    }
}