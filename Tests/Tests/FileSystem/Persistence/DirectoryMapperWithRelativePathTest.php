<?php

namespace Iddigital\Cms\Common\Structure\Tests\FileSystem\Persistence;

use Iddigital\Cms\Common\Structure\FileSystem\Directory;
use Iddigital\Cms\Common\Structure\FileSystem\Persistence\DirectoryMapper;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Iddigital\Cms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DirectoryMapperWithRelativePathTest extends ValueObjectMapperTest
{
    /**
     * @return IEmbeddedObjectMapper
     */
    protected function buildMapper()
    {
        return new DirectoryMapper('path', '/main/path');
    }

    /**
     * @return array[]
     */
    public function mapperTests()
    {
        return [
                [['path' => './'], new Directory('/main/path')],
                [['path' => 'sub/path/'], new Directory('/main/path/sub/path')],
                [['path' => '../parent/path/'], new Directory('/main/parent/path')],
                [['path' => '../../'], new Directory('/')],
        ];
    }
}