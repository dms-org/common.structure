<?php

namespace Iddigital\Cms\Common\Structure\Tests\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Directory;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\DirectoryMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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