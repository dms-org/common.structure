<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\Persistence\DirectoryMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DirectoryMapperTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DirectoryMapper('path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => '/test/abc/'], new Directory('/test/abc')],
                [['path' => '/'], new Directory('/')],
        ];
    }
}