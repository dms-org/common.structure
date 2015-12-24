<?php

namespace Dms\Common\Structure\Tests\FileSystem\Persistence;

use Dms\Common\Structure\FileSystem\Directory;
use Dms\Common\Structure\FileSystem\Persistence\DirectoryMapper;
use Dms\Core\Persistence\Db\Mapping\IEmbeddedObjectMapper;
use Dms\Core\Tests\Persistence\Db\Mapper\ValueObjectMapperTest;

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