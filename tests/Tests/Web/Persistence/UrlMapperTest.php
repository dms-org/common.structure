<?php

namespace Dms\Common\Structure\Tests\Web\Persistence;

use Dms\Common\Structure\Web\Persistence\UrlMapper;
use Dms\Common\Structure\Web\Url;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UrlMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new UrlMapper('uri');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['uri' => 'http://google.com.au'], new Url('http://google.com.au')],
                [
                        ['uri' => 'http://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers'],
                        new Url('http://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers')
                ],
        ];
    }
}