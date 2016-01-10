<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\File;
use Dms\Common\Structure\FileSystem\Persistence\FileMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FileMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new FileMapper('path', 'client_name');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => '/test/abc', 'client_name' => '123'], new File('/test/abc', '123')],
                [['path' => '/doc.pdf', 'client_name' => null], new File('/doc.pdf')],
                [['path' => str_replace('\\', '/', __FILE__), 'client_name' => null], new File(__FILE__)],
        ];
    }
}